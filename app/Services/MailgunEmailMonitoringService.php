<?php

namespace App\Services;

use App\Interfaces\Services\EmailMonitoringServiceInterface;
use App\Models\Company\Participant;
use App\Models\Monitoring\ParticipantMailLog;

class MailgunEmailMonitoringService implements EmailMonitoringServiceInterface
{

    private $states = [
        'delivered' => 1,
        'opened' => 1,
        'clicked' => 1,
        'complained' => 0,
        'unsubscribed' => 0,
        'permanent_fail' => 0,
        'temporary_fail' => 0,
        'failed' => 0
    ];

    public function pollInvitationLog($tracking, $event)
    {
        ['participant_id' => $participantId, 'poll_instance_id' => $pollInstanceId] = $tracking;

        if (!Participant::where('id', $participantId)->exists()) return 0;

        ParticipantMailLog::create([
            'participant_id' => $participantId,
            'event' => $event,
            'valid' => $this->states[$event] ?? 0,
            'description' => 'invitation'
        ]);

        return 1;
    }
    public function pollReminderLog($tracking, $event)
    {
        ['participant_id' => $participantId, 'poll_instance_id' => $pollInstanceId] = $tracking;

        if (!Participant::where('id', $participantId)->exists()) return 0;

        ParticipantMailLog::create([
            'participant_id' => $participantId,
            'event' => $event,
            'valid' => $this->states[$event] ?? 0,
            'description' => 'reminder'
        ]);

        return 1;
    }
}
