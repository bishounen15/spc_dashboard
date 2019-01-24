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
        $model = str_replace('[R]',$this->CUSTOMER == 'GEN1' && $this->CELLCOLOR == 'E' ? 'M' : $this->CELLCOLOR,$model);
        $model = str_replace('[P]',$this->ftd->count() > 0 ? $this->ftd->last()->Bin : 'XXX',$model);
        $model = str_replace('[T]',$this->CTYPE,$model);
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

    public function palletInfo() {
        return $this->hasOne('App\palletData', 'SERIALNO', 'SERIALNO');
    }

    public function ftd() {
        return $this->hasMany('App\ftdData', 'ModuleID', 'SERIALNO');
    }

    public function mes() {
        return $this->hasMany('App\mesData', 'SERIALNO', 'SERIALNO');
    }

    public function extras() {
        return $this->hasOne('App\SerialExtras', 'LBLCNO', 'LBLCNO');
    }
}