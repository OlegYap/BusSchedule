<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteDirectionResource extends JsonResource
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
            'route_id' => $this->route_id,
            'direction' => $this->direction,
            'direction_label' => $this->direction->label(),
            'name' => $this->name,
            'stops' => RouteStopResource::collection($this->whenLoaded('routeStops')),
        ];
    }
}
