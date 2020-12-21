<?php


namespace App\Models\User\Service;

use App\Models\BaseModel;
use App\Models\User\Validator\GroupValidator;
use App\Models\User\Dao\GroupDao;

class GroupService extends BaseModel
{
    public function createGroup($data)
    {
        $validator = new GroupValidator();
        if (!$validator->scene('create')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        if ($this->checkGroup(['name' => $data['name']])) throw new \InvalidArgumentException('角色名称已存在');

        $data['createUserId'] = $data['guid'];
        $data['updateUserId'] = $data['guid'];

        return $this->getGroupDao()->create($data);
    }

    public function updateGroup($id, $data)
    {
        $validator = new GroupValidator();
        if (!$validator->scene('update')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        $where[] = ['id', '=', $id];
        if (!$this->checkGroup($where)) throw new \InvalidArgumentException('角色不存在');

        if (isset($data['name'])) {
            $where = [];
            $where[] = ['id', '!=', $id];
            $where[] = ['name', '=', $data['name']];
            if ($this->checkGroup($where)) throw new \InvalidArgumentException('角色名称已存在');
        }

        $data['updateUserId'] = $data['guid'];
        unset($data['id']);
        return $this->getGroupDao()->where('id', $id)->update($data);
    }

    public function deleteGroup($id)
    {
        if (!$this->checkGroup([['id', '=', $id]])) throw new \InvalidArgumentException('角色不存在');

        return $this->getGroupDao()->where('id', $id)->delete();
    }

    public function listGroup($data)
    {
        $page = !isset($data['Page']) ? 1 : $data['Page'];
        $limit = !isset($data['Limit']) ? 10 : $data['Limit'];

        $where = [];
        if (!empty($data['name'])) $where[] = ['name', 'like', '%' . $data['name'] . '%'];

        $groupData = $this->getGroupDao()->where($where)->paginate($limit, '*', 'page', $page)->toArray();

        return [$groupData['total'], $groupData['data']];
    }

    public function getGroup($id)
    {
        if (!$this->checkGroup(['id' => $id])) throw new \InvalidArgumentException('角色不存在');

        return $this->getGroupDao()->where(['id' => $id])->first();
    }

    public function checkGroup($where)
    {
        return $this->getGroupDao()->where($where)->exists();
    }

    private function getGroupDao(): GroupDao
    {
        return $this->getDao('User:GroupDao');
    }
}
