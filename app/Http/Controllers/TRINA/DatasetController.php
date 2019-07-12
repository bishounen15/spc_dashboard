<?php

namespace App\Http\Controllers\Trina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\StreamedResponse;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        // $sql = "SELECT DISTINCT ".$request->field." FROM ".$request->table." WHERE factory = ? ORDER BY ".$request->field;
        $list = DB::connection('trina')
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
        
        //
        // $validator = null;

        // $validator = Validator::make($request->all(), [
        //     'description' => 'required|unique:sites,description,'.$request->input('id').',id,parent_id,'.$request->input('parent_id'),
        //     'parent_id' => 'required|integer',
        // ], [
        //     'description.required' => 'The site field is required',
        //     'description.unique' => 'This site already exists',
        // ]);
        
        // if ($validator->fails()) {
        //     return Response::json(['Errors' => $validator->errors()]);
        // } else {
            $err_msg = "";

            try {
                $results = DB::connection('trina')
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
    //     }
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
            $results = DB::connection('trina')
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
                    $results = DB::connection('trina')
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
