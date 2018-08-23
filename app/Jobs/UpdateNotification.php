<?php

namespace App\Jobs;

use App\Mail\YieldRecordUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Mail;

class UpdateNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $content;
    protected $receiverAddress;
    protected $newEmailSubject;

    public function __construct($content, $receiverAddress, $newEmailSubject)
    {
        //
        $this->content = $content;
        $this->receiverAddress = $receiverAddress;
        $this->newEmailSubject = $newEmailSubject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->receiverAddress)
            ->send(new YieldRecordUpdated($this->content, $this->newEmailSubject));
    }
}
