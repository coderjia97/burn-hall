<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Helper;

class ModelHelper
{
    protected $dir = '\App\Models\%s%s\%s\Impl\%sImpl';

    public function getService($service, $version = '')
    {
        try {
            return resolve($service.'Service');
        } catch (\Exception $e) {
            app()->singleton($service.'Service', function ($app) use ($service, $version) {
                [$dir, $file] = explode(':', $service);
                $version = $version ? '\\'.$version.'\\' : '';
                $class = sprintf($this->dir, $dir, $version, 'Service', $file.'Service');

                return new $class();
            });

            return resolve($service.'Service');
        }
    }

    public function getDao($service, $version = '')
    {
        try {
            return resolve($service.'Dao');
        } catch (\Exception $e) {
            app()->singleton($service.'Dao', function ($app) use ($service, $version) {
                [$dir, $file] = explode(':', $service);
                $version = $version ? '\\'.$version.'\\' : '';
                $class = sprintf($this->dir, $dir, $version, 'Dao', $file.'Dao');

                return new $class();
            });

            return resolve($service.'Dao');
        }
    }
}
