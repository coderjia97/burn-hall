<?php
/**
 * Sunny 2020/12/15 上午9:38
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Service;

use App\Models\BaseModel;
use App\Models\Log\Service\LogService;
use App\Models\User\Dao\UserDao;
use App\Models\User\Validator\UserValidator;
use App\Toolkit\CharTools;

class UserService extends BaseModel
{
    // 是否为管理员
    public const IS_ADMIN_TRUE = 1;
    public const IS_ADMIN_FALSE = 0;

    // 状态
    public const STATUS_TRUE = 1;
    public const STATUS_FALSE = 0;

    public function create($data)
    {
        $validator = new UserValidator();
        if (!$validator->scene('create')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        $data['salt'] = CharTools::getRandChar(16);
        $data['guid'] = CharTools::generateGuid();
        $data['password'] = sha1(md5($data['salt'] . config('app.salt') . $data['password']) . $data['salt']);
        $data['isAdmin'] = self::IS_ADMIN_FALSE;
        $data['status'] = self::STATUS_TRUE;
        $data['createUserId'] = $this->getCurrentUser()->getId();
        $data['updateUserId'] = $this->getcurrentUser()->getId();

        $user = $this->getUserDao()->create($data);
        $this->getLogService()->createTrace('创建用户', $user);

        return $user;
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
