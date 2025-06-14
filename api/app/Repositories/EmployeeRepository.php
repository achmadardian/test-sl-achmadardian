<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Pagination\Paginator;

class EmployeeRepository {

    /**
     * @param array $data
     *
     * @return Employee
     */
    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    /**
     * @param int $perPage
     * @param string|null $search
     *
     * @return Paginator
     */
    public function getAll(int $perPage, ?string $search = null): Paginator
    {
        $query = Employee::with(['position:id,name'])
        ->select('id', 'name', 'email', 'hired_at', 'ended_at', 'position_id')
        ->when($search, function($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%'. $search . '%');
        })
        ->orderBy('name', 'ASC');

        return $query->simplePaginate($perPage);
    }

    /**
     * @param int $id
     *
     * @return Employee
     */
    public function getById(int $id): ?Employee
    {
        return Employee::with(['position:id,name'])
        ->select('id', 'name', 'email', 'hired_at', 'ended_at', 'position_id')->find($id);
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return int
     */
    public function updateById(array $data, int $id): int
    {
        return Employee::where('id', $id)->update($data);
    }

    /**
     * @param int $id
     *
     * @return int Number of deleted records (0 or 1)
     */
    public function deleteById(int $id): int
    {
        return Employee::destroy($id);
    }
}
