<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class YieldRecordUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $content;
    protected $newEmailSubject;

    public function __construct($content, $newEmailSubject)
    {
        $this->content = $content;
        $this->newEmailSubject = $newEmailSubject;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.yield.updated')
                        ->subject($this->newEmailSubject)
                        ->with('content',$this->content);
    }
}
