<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace Database\Seeders;

use App\Models\User\Service\UserService;
use App\Toolkit\CharTools;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSystemUser();
    }

    protected function createSystemUser(): bool
    {
        $user = DB::table('user')->where('name', 'system')->first();

        if (null === $user) {
            return DB::table('user')->insert([
                'name' => 'system',
                'salt' => CharTools::getRandChar(16),
                'guid' => CharTools::generateGuid(),
                'password' => Hash::make(md5(CharTools::getRandChar(32))),
                'isAdmin' => UserService::IS_ADMIN_TRUE,
                'status' => UserService::STATUS_TRUE,
                'group' => 0,
            ]);
        }

        return true;
    }
}
