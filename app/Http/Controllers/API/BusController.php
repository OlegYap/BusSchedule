<?php

namespace App\Http\Controllers\API;

use App\DTO\BusFinderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\FindBusRequest;
use App\Services\BusFinderService;
use Illuminate\Http\JsonResponse;


class BusController extends Controller
{
    private BusFinderService $busFinderService;

    public function __construct(BusFinderService $busFinderService)
    {
        $this->busFinderService = $busFinderService;
    }

    public function findBus(FindBusRequest $request): JsonResponse
    {
        $dto = BusFinderDTO::fromRequestNames(
            $request->input('from'),
            $request->input('to')
        );

        $result = $this->busFinderService->findBuses($dto);

        return response()->json([
            'from' => $dto->fromStop->name,
            'to' => $dto->toStop->name,
            'buses' => $result,
        ]);
    }
}
