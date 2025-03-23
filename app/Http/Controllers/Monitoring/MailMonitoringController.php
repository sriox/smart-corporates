<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\EmailMonitoringServiceInterface;
use Illuminate\Http\Request;

class MailMonitoringController extends Controller
{

    private $emailMonitoringService;

    public function __construct(EmailMonitoringServiceInterface $emailMonitoringService)
    {
        $this->emailMonitoringService = $emailMonitoringService;
    }

    public function mailgun(Request $request)
    {
        ['event' => $event, 'user-variables' => $tracking] = $request['event-data'];

        if (!$tracking) return 0;

        switch ($tracking['mail_type']) {
            case 'poll:invitation':
                $this->emailMonitoringService->pollInvitationLog($tracking, $event);
                break;
            case 'poll:reminder':
                $this->emailMonitoringService->pollReminderLog($tracking, $event);
                break;

            default:
                # code...
                break;
        }
    }
}
