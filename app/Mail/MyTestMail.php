<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @param  array  $details
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['body'] = $this->details['body'];
        $data['fromName'] = $this->details['fromName'];
        $data['from'] = $this->details['from'];
        $data['url'] = $this->details['url'];
        
        return $this->subject($this->details['title'])
                    ->from($address = 'noreply1@ezead.com', $name = 'EZEAD.COM')
                    ->view('emails.myTestMail', $data);
    }
}
