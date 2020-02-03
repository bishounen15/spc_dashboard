<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class portalCustomer extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'cus01';

    public function classes() {
        return $this->hasMany('App\mesClasses', 'CUSTOMER', 'CUSCODE')->get();
    }
}
