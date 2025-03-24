<?php

namespace App\Models;

use App\Enums\DirectionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function directions(): HasMany
    {
        return $this->hasMany(RouteDirection::class);
    }


    public function getforwardDirection()
    {
        return $this->hasOne(RouteDirection::class)
            ->where('direction', DirectionType::FORWARD->value);
    }

    public function getbackwardDirection()
    {
        return $this->hasOne(RouteDirection::class)
            ->where('direction', DirectionType::BACKWARD->value);
    }
}
