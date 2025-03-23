<?php

namespace App\Models\Poll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    public function dimension()
    {
        return $this->belongsTo(Dimension::class);
    }
}
