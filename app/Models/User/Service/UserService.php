<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Service;

use App\Models\BaseServiceInterface;

interface UserService extends BaseServiceInterface
{
    public function createUser($data): bool;

    public function getUserByGuid($guid): array;

    public function updateUser($guid, $data): bool;

    public function deleteUser($guid): bool;

    public function modify($guid): bool;

    public function searchByPagination($conditions, $orderBy): array;
}
