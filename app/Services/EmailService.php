<?php

namespace App\Services;

use App\Interfaces\Services\EmailServiceInterface;
use Illuminate\Mail\Mailable;
use Mail;

class EmailService implements EmailServiceInterface
{
    public function send($to, Mailable $mail, $queue = false)
    {
        $this->setTracking($mail);
        $destinations = $this->getDestinations($to);
        if (!$destinations) return 0;

        return $queue
            ? Mail::to($destinations)->queue($mail)
            : Mail::to($destinations)->send($mail);
    }

    public function queue($to, Mailable $mail)
    {
        $this->send($to, $mail, true);
    }

    private function setTracking(Mailable &$mail)
    {
        if (!property_exists($mail, 'tracking')) return 1;

        $mail->withSymfonyMessage(function ($message) use ($mail) {
            $headers = $message->getHeaders();

            $keys = array_keys($mail->tracking);
            foreach ($keys as $key) {
                $headers->addTextHeader("X-PM-Metadata-{$key}", $mail->tracking[$key]);
                $headers->addTextHeader("X-Vecindapp-{$key}", $mail->tracking[$key]);
            }
            $headers->addTextHeader("X-Mailgun-Variables", json_encode($mail->tracking));
        });
    }

    private function getDestinations($to)
    {
        if (is_array($to)) {
            $destinations = [];
            foreach ($to as $email) {
                $email = mb_strtolower(trim($email));
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) continue;
                $destinations[] = $email;
            }
            return implode(',', $destinations);
        } else {
            $to = mb_strtolower(trim($to));
            return filter_var($to, FILTER_VALIDATE_EMAIL) ? $to : '';
        }
    }
}
