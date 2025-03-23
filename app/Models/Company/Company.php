<?php

namespace App\Models\Company;

use App\Models\City;
use App\Models\Operations\PollInstance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Core\Company
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @mixin \Eloquent
 */
class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function pollInstances()
    {
        return $this->hasMany(PollInstance::class);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function companyLevels()
    {
        return $this->hasMany(CompanyLevel::class);
    }
}
