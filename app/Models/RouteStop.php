<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class RouteStop extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_direction_id',
        'stop_id',
        'stop_order',
    ];

    public $timestamps = false;

    public function routeDirection(): BelongsTo
    {
        return $this->belongsTo(RouteDirection::class);
    }


    public function stop(): BelongsTo
    {
        return $this->belongsTo(Stop::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
