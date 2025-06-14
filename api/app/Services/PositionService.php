<?php

namespace App\Services;

use App\Models\Position;
use App\Repositories\PositionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;

class PositionService {
    
    /**
     * @var PositionRepository
     */
    protected PositionRepository $positionRepo;

    /**
     * @param PositionRepository $positionRepo
     */
    public function __construct(PositionRepository $positionRepo)
    {
        $this->positionRepo = $positionRepo;
    }

    /**
     * @param array $position
     *
     * @return Position
     */
    public function create(array $position): Position
    {
        return $this->positionRepo->create($position);
    }

    /**
     * @param array $position
     * @param int $id
     *
     * @return Position
     */
    public function updateById(array $position, int $id): Position
    {
        $this->getById($id);

       $this->positionRepo->updateById($position, $id);

       return $this->getById($id);
    }

    /**
     * @param string|null $search
     * @param int $perPage
     *
     * @return Paginator
     */
    public function getAll(int $perPage, ?string $search = null,): Paginator
    {
        return $this->positionRepo->getAll(perPage: $perPage, search: $search);
    }

    /**
     * @param int $id
     *
     * @return Position|null
     */
    public function getById(int $id): Position
    {
        $position = $this->positionRepo->getById($id);

        if (!$position) {
            throw new ModelNotFoundException('get position by id');
        }

        return $position;
    }

    /**
     * @param int $id
     *
     * @return int Number of deleted records (0 or 1)
     */
    public function deleteById(int $id): int
    {
        $this->getById($id);

        return $this->positionRepo->deleteById($id);
    }
}
