<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    public $timestamps = false;


    public function routeStops(): HasMany
    {
        return $this->hasMany(RouteStop::class);
    }
}
