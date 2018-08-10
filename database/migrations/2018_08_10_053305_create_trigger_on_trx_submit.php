<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerOnTrxSubmit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::connection('osi')->unprepared("
        CREATE TRIGGER tr_Update_Inventory AFTER UPDATE ON `transactions` FOR EACH ROW
            BEGIN
                UPDATE office_supplies A INNER JOIN transaction_details B ON A.id = B.item_id
                SET A.current_stock = A.current_stock + (B.qty * 
                    CASE WHEN old.status <> new.status AND new.status = 'Submitted' AND new.type IN ('Incoming','Outgoing') THEN
                        CASE WHEN new.type = 'Incoming' THEN 1 ELSE -1 END
                    ELSE
                        0
                    END
                ) WHERE B.transaction_id = new.id AND old.status <> new.status AND new.status = 'Submitted' AND new.type IN ('Incoming','Outgoing');
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::connection('osi')->unprepared('DROP TRIGGER `tr_Update_Inventory`');
    }
}
