<?php
/**
 * Sunny 2020/12/14 下午4:42
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Service;

use App\Models\BaseModel;
use App\Models\User\Dao\UserDao;
use App\Models\User\Validator\UserValidator;
use App\Toolkit\CharTools;

class UserService extends BaseModel
{
    // 是否为管理员
    public const IS_ADMIN_Y = 1;
    public const IS_ADMIN_N = 0;

    // 状态
    public const STATUS_Y = 1;
    public const STATUS_N = 0;

    public function createUser($data)
    {
        $validator = new UserValidator();

        if (!$validator->scene('create')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        $data['salt'] = CharTools::getRandChar(16);
        $data['guid'] = CharTools::generateGuid();
        $data['password'] = sha1(md5($data['salt'] . config('app.salt') . $data['password']) . $data['salt']);
        $data['isAdmin'] = self::IS_ADMIN_N;
        $data['status'] = self::STATUS_Y;

        return $this->getUserDao()->create($data);
    }

    private function getUserDao(): UserDao
    {
        return $this->getDao('User:UserDao');
    }
}
