<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    //
    protected $connection = "trina";
    protected $table = "df_wo_mat";

    protected $primaryKey = "WorkOrder_ID";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'WorkOrder_ID',
        'Module_Colour',
        'IsBonded',
    ];

    public function productType() {
        return $this->hasOne('App\Models\TRINA\ProductTypes', 'Q1_ID', 'Product_ID');
    }
}
