<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollType extends Model
{
    use HasFactory;

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }
}
