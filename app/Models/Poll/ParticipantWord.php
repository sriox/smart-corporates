<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantWord extends Model
{
    use HasFactory;

    public function openQuestion()
    {
        return $this->belongsTo(OpenQuestion::class);
    }
}
