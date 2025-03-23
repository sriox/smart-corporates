<?php

namespace App\Interfaces\Services;

use Illuminate\Mail\Mailable;

interface EmailServiceInterface
{
    public function send($to, Mailable $mail, $queue = false);
    public function queue($to, Mailable $mail);
}
