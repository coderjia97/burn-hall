<?php

namespace App\Models\User\Service;

use App\Models\BaseServiceInterface;

interface GroupService extends BaseServiceInterface
{
    public function get($id);

    public function createGroup($data): bool;

    public function updateGroup($id, $data): bool;

    public function deleteGroup($id): bool;

    public function searchByPagination($conditions, $orderBy): array;

    public function getAll(): array;
}
