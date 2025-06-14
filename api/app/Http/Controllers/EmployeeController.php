<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\EmployeeService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    use ApiResponse;

    /**
     * @var EmployeeService
     */
    protected EmployeeService $employeeService;

    /**
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
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

        $employees = $this->employeeService->getAll($perPage, $search);
        $dto = EmployeeResource::collection($employees);
        
        return $this->responseSuccess(data: $dto, paginator: $employees);
    }

    /**
     * @param CreateEmployeeRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateEmployeeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $newEmployee = $this->employeeService->create($data);
        $dto = EmployeeResource::make($newEmployee);

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
            $employee = $this->employeeService->getById($id);

            return $this->responseSuccess($employee);
        } catch (ModelNotFoundException) {
            return $this->responseNotFound();
        }
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateEmployeeRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $updateEmployee = $this->employeeService->updateById($data, $id);
            $dto = EmployeeResource::make($updateEmployee);
    
            return $this->responseUpdated($dto);
        } catch (ModelNotFoundException) {
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
            $this->employeeService->deleteById($id);

            return $this->responseDeleted();
        } catch (ModelNotFoundException) {
            return $this->responseNotFound();
        }
    }
}
