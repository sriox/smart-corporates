<?php

namespace App\Models\Monitoring;

use App\Models\Company\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantMailLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
