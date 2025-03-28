<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteStopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'route_direction_id' => $this->route_direction_id,
            'stop_order' => $this->stop_order,
            'stop' => new StopResource($this->whenLoaded('stop')),
        ];
    }
}
