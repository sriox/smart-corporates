<?php

namespace App\Models\Poll;

use App\Models\Operations\PollInstance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function pollType()
    {
        return $this->belongsTo(PollType::class);
    }

    public function pollAnswers()
    {
        return $this->hasMany(PollAnswer::class);
    }

    public function openQuestions()
    {
        return $this->hasMany(OpenQuestion::class);
    }

    public function pollInstances()
    {
        return $this->hasMany(PollInstance::class);
    }
}
