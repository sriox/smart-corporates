<?php

namespace App\Mail\Operations;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PollInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pollInstance;
    public $person;
    public $tracking;
    public $link;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($participant)
    {
        $this->pollInstance = $participant->pollInstance;
        $this->company = $participant->pollInstance->company;
        $this->person = $participant->person;
        $this->tracking = [
            'poll_instance_id' => $this->pollInstance->id,
            'participant_id' => $participant->id,
            'mail_type' => 'poll:invitation'
        ];
        $this->link = config('app.url') .  "/submit/{$participant->code}";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pollName = $this->pollInstance->poll->name;

        return $this
            ->subject("Ha sido invitado a participar en la encuesta: {$pollName}")
            ->view('Emails.Operations.PollInvitation');
    }
}
