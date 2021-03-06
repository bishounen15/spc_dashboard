<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\StreamedResponse;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

use DB;
use Response;
use Validator;

class DatasetController extends Controller
{
    //
    protected $error_codes;

    public function __construct() {
        $this->error_codes = [
            1062 => "You are trying to enter a duplicate record. Please check your input."
        ];
    }

    public function getList(Request $request) {
        $list = DB::connection('web_portal')
                    ->table($request->table)
                    ->select($request->fields)
                    ->where($request->lookup)
                    ->paginate(10);

        return Response::json($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];

        foreach($request->data as $d) {
            $kvp = [];

            foreach($d as $k => $v) {
                array_push($kvp,$v);
            }

            $data[$kvp[0]] = $kvp[1];
        }
        
        
        $err_msg = "";

        try {
            $results = DB::connection('web_portal')
                        ->table($request->table)
                        ->insert($data);

            $req = [];
            $req['table'] = $request->table;
            $req['data'] = $data;
            $req['type'] = "INSERT";
            $req['user_id'] = $request->user_id;
            
            $res = $this->auditTrail($req);
            $err_msg = $res;
        } catch (\Throwable $th) {
            $results = $th;

            try {
                $err_msg = $this->error_codes[$results->errorInfo[1]];
            } catch (\Throwable $th) {
                $err_msg = $results->errorInfo[2];
            }
        } finally {
            return Response::json($err_msg);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $err_msg = "";
        $data = [];

        try {
            $results = DB::connection('web_portal')
                            ->table($request->table)
                            ->where($request->data)
                            ->first();
            
            $data['data'] = $results;
        } catch (\Throwable $th) {
            $results = $th;

            try {
                $err_msg = $this->error_codes[$results->errorInfo[1]];
            } catch (\Throwable $th) {
                $err_msg = $results->errorInfo[2];
            }
        } finally {
            $data['error'] = $err_msg;
            return Response::json($data);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = [];

        foreach($request->data as $d) {
            $kvp = [];

            foreach($d as $k => $v) {
                array_push($kvp,$v);
            }

            $data[$kvp[0]] = $kvp[1];
        }

        $err_msg = "";

        try {
            $results = DB::connection('web_portal')
                            ->table($request->table)
                            ->where($request->id_field,$request->id_value)
                            ->update($data);
            
            $req = [];
            $req['table'] = $request->table;
            $req['data'] = $data;
            $req['type'] = "UPDATE";
            $req['user_id'] = $request->user_id;
            
            $res = $this->auditTrail($req);
            $err_msg = $res;
        } catch (\Throwable $th) {
            $results = $th;

            try {
                $err_msg = $this->error_codes[$results->errorInfo[1]];
            } catch (\Throwable $th) {
                $err_msg = $results->errorInfo[2];
            }
        } finally {
            return Response::json($err_msg);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $err_msg = "";

        try {
            $results = DB::connection('web_portal')
                            ->table($request->table)
                            ->where($request->data)
                            ->delete();

            $req = [];
            $req['table'] = $request->table;
            $req['data'] = $request->data;
            $req['type'] = "DELETE";
            $req['user_id'] = $request->user_id;
            
            $res = $this->auditTrail($req);
            $err_msg = $res;
        } catch (\Throwable $th) {
            $results = $th;

            try {
                $err_msg = $this->error_codes[$results->errorInfo[1]];
            } catch (\Throwable $th) {
                $err_msg = $results->errorInfo[2];
            }
        } finally {
            return Response::json($err_msg);
        }
    }

    public function auditTrail($request) {
        $data = [];
        $err_msg = "";
        
        try {
            $data['table_name'] = $request['table'];
            $data['trx_type'] = $request['type'];

            if ($request['type'] == "INSERT") {
                $data['new_value'] = json_encode($request['data']);
            } elseif ($request['type'] == "DELETE") {
                $data['old_value'] = json_encode($request['data']);
            }

            $data['user_id'] = $request['user_id'];
        
            $results = DB::connection('trina')
                        ->table('solarph.audit_trail')
                        ->insert($data);
        } catch (\Throwable $th) {
            $results = $th;

            try {
                $err_msg = $this->error_codes[$results->errorInfo[1]];
            } catch (\Throwable $th) {
                $err_msg = $results->errorInfo[2];
            }
        } finally {
            return $err_msg;
        }
    }

    public function downloadTemplate(Request $request) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $c = "A";

        $sheet->setCellValue($c.'1', "DO NOT MODIFY THIS TEMPLATE. JUST ADD THE DATA NEEDED STARTING AT ROW 3.");
        foreach($request->columns as $columns) {
            $sheet->setCellValue($c.'2', $columns['display_name']);
            $c++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$request->name.' Template.xls"');
        $writer = new Xls($spreadsheet);
        $writer->save("php://output");
    }

    public function upload(Request $request) {
        if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
            // $data = $_FILES['file']['tmp_name'];
            $table = $request->input('table');
            $columns = json_decode($request->input('columns'));
            $user_id = $request->input('user_id');
            $title = $request->input('name');

            $cols = [];
            foreach($columns as $column) {
                array_push($cols,$column->name."|".$column->type);
            }

            $inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
            $inputFileName = $_FILES['file']['tmp_name'];

            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($inputFileName);

            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Results');

            $i = 3;
            $ci = "";

            while($sheet->getCell('A'.$i)->getValue() != "") {
                $insert = [];
                $ci = "A";

                foreach($cols as $k => $v) {
                    $cdata = [];
                    $cdata = explode("|",$v);

                    if ($cdata[1] == "date") {
                        $val = date("Y-m-d",strtotime($sheet->getCell($ci.$i)->getFormattedValue()));
                    } else {
                        $val = $sheet->getCell($ci.$i)->getValue();
                    }

                    $insert[$cdata[0]] = $val;
                    $ci++;
                }

                $err_msg = "Success";

                try {
                    $results = DB::connection('web_portal')
                                ->table($table)
                                ->insert($insert);
                    
                    $req = [];
                    $req['table'] = $table;
                    $req['data'] = $insert;
                    $req['type'] = "INSERT";
                    $req['user_id'] = $user_id;
                    
                    $res = $this->auditTrail($req);
                    $err_msg = $res == "" ? "Success" : $res;
                } catch (\Throwable $th) {
                    $results = $th;
        
                    try {
                        $err_msg = $this->error_codes[$results->errorInfo[1]];
                    } catch (\Throwable $th) {
                        $err_msg = $results->errorInfo[2];
                    }
                }                

                $sheet->setCellValue($ci.$i, $err_msg);

                $i++;
            }

            $sheet->setCellValue($ci."2", "Upload Remarks");

            $writer = new Csv($spreadsheet);
            $writer->save("php://output");

            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);

            $data = "SUCCESS";
        } else {
            $data = "NO FILE SELECTED.";
        }
    }
}
