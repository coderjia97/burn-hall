<?php
/**
 * Sunny 2020/12/14 下午1:51
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
    public function createUser($data)
    {
        $validator = new UserValidator();

        if (!$validator->scene('create')->check($data)) {
            throw new \InvalidArgumentException($validator->getError());
        }

        $data['salt'] = CharTools::getRandChar(16);
        $data['guid'] = CharTools::generateGuid();
        $data['password'] = sha1(md5($data['salt'].config('app.salt').$data['password']).$data['salt']);

        return $this->getUserDao()->create($data);
    }

    private function getUserDao(): UserDao
    {
        return $this->getDao('User:UserDao');
    }
}
