<?php

namespace App\Models\User\Service;

use App\Models\BaseModel;
use App\Models\User\Dao\GroupDao;
use App\Models\User\Validator\GroupValidator;

class GroupService extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->dao = $this->getGroupDao();
    }

    public function createGroup($data): bool
    {
        $validator = new GroupValidator();
        if (!$validator->scene('create')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        if ($this->getByName($data['name'])) {
            throw new \InvalidArgumentException('角色名称已存在');
        }

        $data['createUserId'] = $this->getCurrentUser()->getId();
        $data['updateUserId'] = $this->getCurrentUser()->getId();

        $this->getGroupDao()->create($data);

        return true;
    }

    public function updateGroup($id, $data): bool
    {
        $validator = new GroupValidator();
        if (!$validator->scene('update')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }
        // todo 只取有用的字段做更新

        $groupInfo = $this->get($id);
        if (empty($groupInfo)) {
            throw new \InvalidArgumentException('角色不存在');
        }

        $this->checkName($id, $data['name']);

        $data['updateUserId'] = $this->getCurrentUser()->getId();

        $this->getGroupDao()->where('id', $id)->update($data);

        return true;
    }

    public function deleteGroup($id): bool
    {
        if (!$this->get($id)) {
            throw new \InvalidArgumentException('角色不存在');
        }

        $this->getGroupDao()->where('id', $id)->delete();

        return true;
    }

    public function searchByPagination($conditions, $orderBy): array
    {
        [$offset, $limit] = $this->getOffsetAndLimit();

        $conditions = $this->prepareConditions($conditions);

        $data = $this->search($conditions, $orderBy, $offset, $limit);
        $count = $this->count($conditions);

        return [
            'data' => $data,
            'paging' => [
                'total' => $count,
                'offset' => $offset,
                'limit' => $limit,
            ],
        ];
    }

    public function getGroup($id)
    {
        $groupInfo = $this->get($id);
        if (!$groupInfo) {
            throw new \InvalidArgumentException('角色不存在');
        }

        return $groupInfo;
    }

    protected function prepareConditions($conditions): array
    {
        $newConditions = [];

        if (!empty($conditions['name'])) {
            $newConditions[] = ['name', 'like', '%'.$conditions['name'].'%'];
        }

        return $newConditions;
    }

    protected function checkName($id, $name): bool
    {
        $group = $this->getByName($name);

        if (!empty($group) && $group['id'] != $id) {
            throw new \InvalidArgumentException('角色名称已存在');
        }

        return true;
    }

    protected function getByName($name)
    {
        return $this->getGroupDao()->where(['name' => $name])->first()->toArray();
    }

    private function getGroupDao(): GroupDao
    {
        return $this->getDao('User:GroupDao');
    }
}
