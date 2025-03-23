<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenQuestionWord extends Model
{
    use HasFactory;

    protected $table = 'v_open_question_words';
    protected $casts = ['weight' => 'decimal:4'];

    public function openQuestion()
    {
        return $this->belongsTo(OpenQuestion::class);
    }
}
