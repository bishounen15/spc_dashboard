<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\labelTemplate;

class SerialInfo extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lbl02';

    public function modelName() {
        $model = $this->template() == null ? $this->customerInfo->PRODCODE : $this->template()->MODELNAME;
        $model = str_replace('[C]',$this->CELLCOUNT,$model);
        $model = str_replace('[R]',$this->CELLCOLOR,$model);
        $model = str_replace('[P]',$this->ftd->count() > 0 ? $this->ftd->last()->Bin : 'XXX',$model);
        return $model;
    }

    public function template() {
        // return $this->hasOne('App\labelTemplate', 'TMPCODE', 'TEMPLATE');
        return labelTemplate::where([
            ['CUSTOMER',$this->CUSTOMER],
            ['TMPCODE',$this->TEMPLATE],
        ])->first();
    }

    public function customerInfo() {
        return $this->hasOne('App\portalCustomer', 'CUSCODE', 'CUSTOMER');
    }

    public function ftd() {
        return $this->hasMany('App\ftdData', 'ModuleID', 'SERIALNO');
    }
}