<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenQuestion extends Model
{
    use HasFactory;

    public function openQuestionWords()
    {
        return $this->hasMany(OpenQuestionWord::class)->where('weight', '>=', 0.5);
    }
}
