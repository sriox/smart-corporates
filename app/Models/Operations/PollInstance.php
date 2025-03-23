<?php

namespace App\Models\Operations;

use App\Models\Company\Company;
use App\Models\Company\Participant;
use App\Models\Poll\Poll;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollInstance extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = ['completedCount', 'participantsCount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function getCompletedCountAttribute()
    {
        return $this->participants()->whereNotNull('finish_at')->count();
    }

    public function getParticipantsCountAttribute()
    {
        return $this->participants->count();
    }
}
