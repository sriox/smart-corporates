<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }
}
