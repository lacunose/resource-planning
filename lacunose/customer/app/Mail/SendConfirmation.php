<?php

namespace Lacunose\Customer\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($confirm)
    {
        $this->confirm    = $confirm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->view('tacl::emails.confirmation')
                ->with([
                    'name'          => $this->confirm['customer']['name'],
                    'token'         => $this->confirm['token'],
                    'description'   => $this->confirm['description'],
                ])
                ->subject(ucwords($this->confirm['customer']['name'].', '.$this->confirm['title']))
                ->from(env('MAIL_FROM_ADDRESS', 'hello@thunderlab.id'), env('MAIL_FROM_NAME', 'THUNDERLAB'))
                // ->to([$this->confirm['customer']['email']])
                ;
    }
}
