<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ShareSurvey extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = $this->data['sender'];
        $subject = $this->data['surveyTitle'];
        $name = $this->data['username'];

        return $this->view('email.shareSurvey')
            ->from($address, $name)
            ->subject($subject)
            ->with([ 'linkSurvey' => $this->data['linkSurvey']]);
    }
}
