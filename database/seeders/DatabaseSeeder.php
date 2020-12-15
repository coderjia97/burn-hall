<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $files = File::files(database_path('seeders'));

        foreach ($files as $file) {
            $class = 'Database\\Seeders\\'.$file->getFilenameWithoutExtension();

            if (__CLASS__ !== $class) {
                $this->call($class);
            }
        }
    }
}
