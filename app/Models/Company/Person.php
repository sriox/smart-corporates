<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $appends = ['name'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function getNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
