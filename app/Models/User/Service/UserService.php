<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Service;

use App\Models\BaseModel;
use App\Models\Log\Service\LogService;
use App\Models\User\Dao\UserDao;
use App\Models\User\Validator\UserValidator;
use App\Toolkit\CharTools;
use Illuminate\Support\Facades\Hash;
use App\Toolkit\ArrayTools;


class UserService extends BaseModel
{
    // 是否为管理员
    public const IS_ADMIN_TRUE = 1;
    public const IS_ADMIN_FALSE = 0;

    // 状态
    public const STATUS_TRUE = 1;
    public const STATUS_FALSE = 0;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->dao = $this->getUserDao();
    }

    public function createUser($data): bool
    {
        $validator = new UserValidator();
        if (!$validator->scene('create')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }
        if ($this->getByName($data['name'])) {
            throw new \InvalidArgumentException('用户名称已存在');
        }

        $data['salt'] = CharTools::getRandChar(16);
        $data['guid'] = CharTools::generateGuid();
        $data['password'] = Hash::make(sha1(md5($data['salt'].config('app.salt').$data['password']).$data['salt']));
        $data['isAdmin'] = self::IS_ADMIN_FALSE;
        $data['status'] = self::STATUS_TRUE;
        $data['createUserId'] = $this->getCurrentUser()->getId();
        $data['updateUserId'] = $this->getCurrentUser()->getId();

        $this->getUserDao()->create($data);
        $this->getLogService()->createTrace('创建:用户'.$data['name'], $data);

        return true;
    }

    public function getUser($guid): array
    {
        $userInfo = $this->getUserInfo($guid);
        if (!$userInfo) {
            throw new \InvalidArgumentException('用户不存在');
        }

        return $userInfo;
    }

    public function updateUser($guid,$data): bool
    {
        $validator = new UserValidator();
        if (!$validator->scene('update')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        $groupInfo = $this->getUserInfo($guid);
        if (empty($groupInfo)) {
            throw new \InvalidArgumentException('用户不存在');
        }

        $this->checkName($guid, $data['name']);

        $data = ArrayTools::parts($data,['name','email','password','salt','group','status']);
        if(!empty($data['password'])){
            $data['password'] = Hash::make(sha1(md5($data['salt'].config('app.salt').$data['password']).$data['salt']));
        }
        $data['updateUserId'] = $this->getCurrentUser()->getId();

        $this->getUserDao()->where('guid', $guid)->update($data);
        $this->getLogService()->createTrace('修改:用户'.$guid,$data);

        return true;
    }

    public function deleteUser($guid): bool
    {
        if (!$this->getUserInfo($guid)) {
            throw new \InvalidArgumentException('用户不存在');
        }

        $this->getUserDao()->where('guid', $guid)->delete();
        $this->getLogService()->createTrace('删除:用户', $guid);

        return true;
    }

    public function modify($guid): bool
    {
        $userInfo = $this->getUserInfo($guid);
        if(empty($userInfo)){
            throw new \InvalidArgumentException('用户不存在');
        }
        $data['status'] = 0 == $userInfo['status'] ? 1 : 0;

        $result = $this->getUserDao()->where('guid', $guid)->update($data);
        $this->getLogService()->createTrace('修改状态:用户'.$guid,$data);

        return $result;
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

    protected function getUserInfo($guid): array
    {
        $data = $this->dao->where(['guid' => $guid])->first();

        return $data?$data->toArray():[];
    }

    protected function checkName($guid, $name): bool
    {
        $group = $this->getByName($name);

        if (!empty($group) && $group['guid'] != $guid) {
            throw new \InvalidArgumentException('用户名称已存在');
        }

        return true;
    }

    protected function getByName($name):array
    {
        $userData = $this->getUserDao()->where(['name' => $name])->first();
        return $userData?$userData->toArray():[];
    }

    protected function prepareConditions($conditions): array
    {
        $newConditions = [];

        if (!empty($conditions['name'])) {
            $newConditions[] = ['name', 'like', '%'.$conditions['name'].'%'];
        }

        return $newConditions;
    }

    private function getUserDao(): UserDao
    {
        return $this->getDao('User:UserDao');
    }

    private function getLogService(): LogService
    {
        return $this->getService('Log:LogService');
    }
}
