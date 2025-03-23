<?php

namespace App\Jobs\Operations;

use App\Interfaces\Services\EmailServiceInterface;
use App\Interfaces\Services\PollInstanceServiceInterface;
use App\Mail\Operations\PollInvitationMail;
use App\Models\Company\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPollInvitations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pollInstance;
    public $people;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pollInstance, $people)
    {
        $this->pollInstance = $pollInstance;
        $this->people = $people;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PollInstanceServiceInterface $pollInstanceService)
    {
        $pollInstanceService->sendInvitations($this->pollInstance, $this->people);
        return 1;
    }
}
