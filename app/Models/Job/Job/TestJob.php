<?php
/**
 * Sunny 2020/12/15 下午8:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\Job\Job;

use App\Models\Job\AbstractJob;

class TestJob extends AbstractJob
{
    public $expression = '*/1 * * * *';
    public $name = 'test1';
    public $status = false;

    public function execute($args = []): bool
    {
        echo 'test job';

        return true;
    }
}
