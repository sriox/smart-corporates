<?php

namespace App\Interfaces\Services;

interface PollInstanceServiceInterface
{
    public function getInvitation($pollInstace, $person);
    public function sendInvitations($pollInstace, $peopleIds);
    public function sendReminder($participant);
}
