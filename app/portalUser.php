<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class portalUser extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'sys01';

    public function mesUser() {
        return $this->belongsTo('App\mesUser', 'USERID', 'USRCODE');
    }
}
