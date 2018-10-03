<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerialExtras extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lbl04';

    public function items() {
        return json_decode($this->ITEMS);
    }

    public function lots($list = true) {
        $myLots = json_decode($this->LOTS);
        if ($list) {
            $lots = $myLots;
        } else {
            $lots = '';
            foreach($myLots as $lot) {
                $lots .= ($lots == '' ? '' : '|') . $lot->lot_number;
            }
        }
        return $lots;
    }
}
