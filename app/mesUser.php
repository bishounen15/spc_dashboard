<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mesUser extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lts00';

    public function userInfo() {
        return $this->belongsTo('App\portalUser', 'USRCODE', 'USERID');
    }

    public function assignment() {
        return $this->hasMany('App\mesAssignment', 'USRCODE', 'USRID');
    }
}
