<?php

namespace AkiCreative\AkiForms\Models;

use AkiCreative\AkiForms\Models\Akinotification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailQueue extends Mailable
{
    use Queueable, SerializesModels;

    protected $row;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Akinotification $row)
    {
         $this->row = $row;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->row->email_fromemail, $this->row->email_fromname)->to($this->row->email_toemail)->html($this->row->body)->subject($this->row->email_subject);
    }
}
