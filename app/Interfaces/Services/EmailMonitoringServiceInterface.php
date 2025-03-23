<?php

namespace App\Interfaces\Services;

interface EmailMonitoringServiceInterface
{
    public function pollInvitationLog($tracking, $event);
    public function pollReminderLog($tracking, $event);
}
