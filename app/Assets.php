<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AssetModels;

class Assets extends Model
{
    //
    protected $connection = 'assets';
    protected $table = 'tbl_general';
    //Primary Key
    protected $primaryKey = 'id';

    protected $fillable = [
        'serial',
        'type', 
        'brand',
        'model',
        'os',
        'host_name',
        'id_number',
        'name',
        'dept',
        'site',
        'sub_site',
        'status',
        'device_status',
        'proc',
        'ram',
        'hdd',
        'gfx_card',
        'remarks',
    ];

    public function network() {
        return $this->hasMany('App\NetInterface', 'id', 'id');
    }

    public function software() {
        return $this->hasMany('App\Software', 'id', 'id');
    }

    public function partitions() {
        return $this->hasMany('App\HDDPartitions', 'id', 'id');
    }

    public function device_model() {
        $model = AssetModels::where([
            ["mc_model",$this->model],
            ["brand",$this->brand],
        ])->first();

        if ($model == null) {
            return $this->model;
        } else {
            return $model->model;
        }
    }

    public function image_path() {
        $path = "/storage/Images/Model/" . $this->device_model() . ".png";

        if (file_exists( public_path(). $path )) {
            return $path;
        } else {
            return "/storage/Images/Model/" . $this->type . ".png";
        }     
    }
}
