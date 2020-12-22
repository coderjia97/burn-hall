<?php


namespace App\Models\User\Service;

use App\Models\BaseModel;
use App\Models\User\Validator\GroupValidator;
use App\Models\User\Dao\GroupDao;

class GroupService extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->dao=$this->getGroupDao();
    }

    public function createGroup($data)
    {
        $validator = new GroupValidator();
        if (!$validator->scene('create')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        if ($this->getByName($data['name'])) {
            throw new \InvalidArgumentException('角色名称已存在');
        }

        $data['createUserId'] = $data['guid'];
        $data['updateUserId'] = $data['guid'];

        $this->getGroupDao()->create($data);
        return true;
    }

    public function updateGroup($id, $data)
    {
        $validator = new GroupValidator();
        if (!$validator->scene('update')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        $groupInfo = $this->get($id);
        if (empty($groupInfo)) {
            throw new \InvalidArgumentException('角色不存在');
        }

        $this->checkoName($id,$data['name']);

        $data['updateUserId'] = $data['guid'];
        unset($data['id']);
        unset($data['guid']);
        $this->getGroupDao()->where('id', $id)->update($data);

        return true;
    }

    public function deleteGroup($id)
    {
        if (!$this->get($id)) {
            throw new \InvalidArgumentException('角色不存在');
        }

        $this->getGroupDao()->where('id', $id)->delete();

        return true;
    }


    public function listGroup($data)
    {
        $offset = !isset($data['offset']) ? 0 : $data['offset'];
        $limit = !isset($data['limit']) ? 10 : $data['limit'];

        $conditions = [];
        if (!empty($data['name'])) {
            $conditions[] = ['name', 'like', '%' . $data['name'] . '%'];
        }

        $count = $this->count($conditions);
        $groupData = $this->search($conditions,['id'=>'desc'],$offset,$limit);

        return [$count,$groupData];
    }

    public function getGroup($id)
    {
        $groupInfo = $this->get($id);
        if (!$groupInfo) {
            throw new \InvalidArgumentException('角色不存在');
        }

        return $groupInfo;
    }

    protected function checkoName($id,$name){
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
