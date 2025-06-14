<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;

class EmployeeService {

    /**
     * @var EmployeeRepository
     */
    protected EmployeeRepository $employeeRepo;

    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepo = $employeeRepo;
    }

    /**
     * @param array $data
     *
     * @return Employee
     */
    public function create(array $data): Employee
    {
        $newEmployee = $this->employeeRepo->create($data);

        return $this->getById($newEmployee->id);
    }

    /**
     * @param int $perPage
     * @param string|null $search
     *
     * @return Paginator
     */
    public function getAll(int $perPage, ?string $search = null): Paginator
    {
        return $this->employeeRepo->getAll($perPage, $search);
    }

    /**
     * @param int $id
     *
     * @return Employee
     */
    public function getById(int $id): Employee
    {
        $employee = $this->employeeRepo->getById($id);

        if (!$employee) {
            throw new ModelNotFoundException('get employee by id');
        }

        return $employee;
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return Employee
     */
    public function updateById(array $data, int $id): Employee
    {
        $this->getById($id);

        $this->employeeRepo->updateById(data: $data, id: $id);

        return $this->getById($id);
    }

    /**
     * @param int $id
     *
     * @return int Number of deleted records (0 or 1)
     */
    public function deleteById(int $id): int
    {
        $this->getById($id);

        return $this->employeeRepo->deleteById($id);
    }
}
