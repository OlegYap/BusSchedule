<?php

namespace App\DTO;


class RouteDTO
{
    public ?string $name;
    public array $directions;

    public function __construct(?string $name, array $directions)
    {
        $this->name = $name;
        $this->directions = $directions;
    }

    public static function fromRequestData(?string $name, array $directions): self
    {
        $directionDTOs = [];

        foreach ($directions as $direction) {
            $directionDTOs[] = RouteDirectionDTO::fromRequestData(
                $direction['direction'],
                $direction['stops']
            );
        }

        return new self($name, $directionDTOs);
    }
}
