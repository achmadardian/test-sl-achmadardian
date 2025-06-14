<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePositionRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\PositionResource;
use App\Services\PositionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    use ApiResponse;

    /**
     * @var PositionService
     */
    protected PositionService $positionService;

    /**
     * @param PositionService $positionService
     */
    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    /**
     * @param PaginationRequest $request
     *
     * @return JsonResponse
     */
    public function index(PaginationRequest $request): JsonResponse
    {
        $request->validated();
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', null);

        $positions = $this->positionService->getAll(perPage: $perPage, search: $search);
        $dto = PositionResource::collection($positions);
        
        return $this->responseSuccess($dto, paginator: $positions);
    }

    /**
     * @param CreatePositionRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreatePositionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $newPosition = $this->positionService->create($data);
        $dto = PositionResource::make($newPosition);

        return $this->responseCreated($dto);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $position = $this->positionService->getById($id);
            $dto = PositionResource::make($position);
            
            return $this->responseSuccess($dto);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->responseNotFound();
        }
    }

    /**
     * @param CreatePositionRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(CreatePositionRequest $request, int $id): JsonResponse
    {
       try {
            $data = $request->validated();
            $updatePosition = $this->positionService->updateById($data, $id);
            $dto = PositionResource::make($updatePosition);

            return $this->responseupdated($dto);
       } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->responseNotFound();
       }
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->positionService->deleteById($id);
            
            return $this->responsedeleted();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->responseNotFound();
        }
    }
}
