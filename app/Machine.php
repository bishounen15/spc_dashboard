<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\DTType;

class Machine extends Model implements Auditable
{
    //
    protected $connection = 'proddt';
    protected $fillable = [
        'code',
        'descr',
        'capacity',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'descr',
        'capacity',
    ];

    public function issues() {
        return $this->hasMany('App\DTType', 'machine_id', 'id');
    }

    public function categories() {
        return DTType::join("categories","dt_types.category_id","=","categories.id")
                    ->join("machines","dt_types.machine_id","=","machines.id")
                    ->where("dt_types.machine_id",$this->id)->distinct()->get(['categories.id','categories.descr','machines.capacity']);
    }
}
