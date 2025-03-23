<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    use HasFactory;

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
