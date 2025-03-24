<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStopRequest;
use App\Http\Requests\UpdateStopRequest;
use App\Http\Resources\StopResource;
use App\Models\Stop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StopController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $stops = Stop::all();
        return StopResource::collection($stops);
    }


    public function show(Stop $stop): StopResource
    {
        return new StopResource($stop);
    }


    public function store(StoreStopRequest $request): JsonResponse
    {
        $stop = Stop::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Остановка успешно создана',
            'stop' => new StopResource($stop)
        ], 201);
    }


    public function update(UpdateStopRequest $request, Stop $stop): JsonResponse
    {
        $stop->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Остановка успешно обновлена',
            'stop' => new StopResource($stop)
        ]);
    }


    public function destroy(Stop $stop): JsonResponse
    {
        $stop->delete();

        return response()->json(null, 204);
    }
}
