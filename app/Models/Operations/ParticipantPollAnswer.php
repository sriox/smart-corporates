<?php

namespace App\Models\Operations;

use App\Models\Company\Participant;
use App\Models\Poll\PollAnswer;
use App\Models\Poll\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantPollAnswer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function pollAnswer()
    {
        return $this->belongsTo(PollAnswer::class);
    }
}
