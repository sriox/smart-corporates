<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    public function pollInstance()
    {
        return $this->belongsTo(PollInstance::class);
    }
}
