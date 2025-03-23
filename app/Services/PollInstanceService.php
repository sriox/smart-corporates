<?php

namespace App\Services;

use App\Interfaces\Services\EmailServiceInterface;
use App\Interfaces\Services\PollInstanceServiceInterface;
use App\Mail\Operations\PollInvitationMail;
use App\Mail\Operations\PollReminderMail;
use App\Models\Company\Person;
use Illuminate\Support\Str;

class PollInstanceService implements PollInstanceServiceInterface
{
    private $emailService;

    public function __construct(EmailServiceInterface $emailService)
    {
        $this->emailService = $emailService;
    }

    public function getInvitation($pollInstance, $person)
    {
        $participant = $person->participants()->where('poll_instance_id', $pollInstance->id)->first();
        if ($participant) return $participant;

        $code = Str::uuid();

        $participant = $person->participants()->create([
            'poll_instance_id' => $pollInstance->id,
            'code' => $code
        ]);

        return $participant;
    }

    public function sendInvitations($pollInstance, $peopleIds)
    {
        $people = Person::whereIn('id', $peopleIds)->get();
        foreach ($people as $person) {
            $participant = $this->getInvitation($pollInstance, $person);
            $mail = new PollInvitationMail($participant);
            $this->emailService->send($person->email, $mail);
        }
        return 1;
    }

    public function sendReminder($participant)
    {
        $mail = new PollReminderMail($participant);
        $this->emailService->send($participant->person->email, $mail);
        return 1;
    }
}
