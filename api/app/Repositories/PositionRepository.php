<?php

namespace App\Repositories;

use App\Models\Position;
use Illuminate\Pagination\Paginator;

class PositionRepository {
    
    /**
     * @param array $position
     *
     * @return Position
     */
    public function create(array $position): Position
    {
        return Position::create([
            'name' => $position['name']
        ]);
    }

    /**
     * @param string|null $search
     * @param int $perPage
     *
     * @return Paginator
     */
    public function getAll(int $perPage, ?string $search = null,): Paginator
    {
        $query = Position::select('id', 'name')
        ->when($search, function($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('name', 'ASC');

        return $query->simplePaginate($perPage);
    }

    /**
     * @param int $id
     *
     * @return Position|null
     */
    public function getById(int $id): ?Position
    {
        return Position::select('id', 'name')->find($id);
    }

    /**
     * @param array $position
     * @param int $id
     *
     * @return int
     */
    public function updateById(array $position, int $id): int
    {
        return Position::where('id', $id)->update($position);
    }

    /**
     * @param int $id
     *
     * @return int Number of deleted records (0 or 1)
     */
    public function deleteById(int $id): int
    {
        return Position::destroy($id);
    }
}
