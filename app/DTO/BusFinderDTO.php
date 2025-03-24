<?php

namespace App\DTO;

use App\Models\Stop;

class BusFinderDTO
{
    public Stop $fromStop;
    public Stop $toStop;

    public function __construct(Stop $fromStop, Stop $toStop)
    {
        $this->fromStop = $fromStop;
        $this->toStop = $toStop;
    }

    public static function fromRequestNames(string $fromStopName, string $toStopName): self
    {
        $fromStop = Stop::where('name', $fromStopName)->firstOrFail();
        $toStop = Stop::where('name', $toStopName)->firstOrFail();

        return new self($fromStop, $toStop);
    }
}
