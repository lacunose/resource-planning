<?php

namespace Lacunose\Customer\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notif, $attach = null)
    {
        $this->notif    = $notif;
        $this->attach   = $attach;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->attach){
            return $this
                    ->view('tcust::emails.notification')
                    ->with([
                        'name'          => $this->notif['customer']['name'],
                        'url'           => $this->notif['url'],
                        'description'   => $this->notif['description'],
                    ])
                    ->subject(ucwords($this->notif['customer']['name'].', '.$this->notif['title']))
                    ->from($this->notif['sender']['email'], $this->notif['sender']['name'])
                    ->attachData($this->attach->output(), "attachment.pdf")
                    ;
        } else {
            return $this
                ->view('tcust::emails.notification')
                ->with([
                    'name'          => $this->notif['customer']['name'],
                    'url'           => $this->notif['url'],
                    'description'   => $this->notif['description'],
                ])
                ->subject(ucwords($this->notif['customer']['name'].', '.$this->notif['title']))
                ->from($this->notif['sender']['email'], $this->notif['sender']['name'])
                ;
        }
    }
}
