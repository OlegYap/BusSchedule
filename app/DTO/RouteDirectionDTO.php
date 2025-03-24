<?php

namespace App\DTO;
use App\Enums\DirectionType;

class RouteDirectionDTO
{
    public DirectionType $direction;
    public array $stopIds;

    public function __construct(DirectionType $direction, array $stopIds)
    {
        $this->direction = $direction;
        $this->stopIds = $stopIds;
    }


    public static function fromRequestData(string $direction, array $stopIds): self
    {
        return new self(
            DirectionType::from($direction),
            $stopIds
        );
    }
}
