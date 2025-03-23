<?php

namespace App\Models\Company;

use App\Models\Monitoring\ParticipantMailLog;
use App\Models\Operations\ParticipantOpenQuestionAnswer;
use App\Models\Operations\ParticipantPollAnswer;
use App\Models\Operations\PollInstance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function pollInstance()
    {
        return $this->belongsTo(PollInstance::class);
    }

    public function participantPollAnswers()
    {
        return $this->hasMany(ParticipantPollAnswer::class);
    }

    public function participantOpenQuestionAnswers()
    {
        return $this->hasMany(ParticipantOpenQuestionAnswer::class);
    }

    public function latestState()
    {
        return $this->hasOne(ParticipantMailLog::class)->latestOfMany();
    }
}
