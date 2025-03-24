<?php

namespace App\Models;


use App\Enums\DirectionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class RouteDirection extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'direction',
        'name',
    ];

    protected $casts = [
        'direction' => DirectionType::class,
    ];

    public $timestamps = false;

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function routeStops(): HasMany
    {
        return $this->hasMany(RouteStop::class);
    }

    public function stops()
    {
        return $this->belongsToMany(Stop::class, 'route_stops', 'route_direction_id', 'stop_id')
            ->withPivot('stop_order')
            ->orderBy('stop_order');
    }

}
