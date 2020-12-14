<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Helper;

class ModelHelper
{
    protected $dir = '\App\Models\%s%s\%s\%s';

    public function getService($service, $version = '')
    {
        try {
            return resolve($service);
        } catch (\Exception $e) {
            app()->singleton($service, function ($app) use ($service, $version) {
                [$dir, $file] = explode(':', $service);
                $version = $version ? '\\' . $version . '\\' : '';
                $class = sprintf($this->dir, $dir, $version, 'Service', $file);

                return new $class();
            });

            return resolve($service);
        }
    }

    public function getDao($service, $version = '')
    {
        try {
            return resolve($service);
        } catch (\Exception $e) {
            app()->singleton($service, function ($app) use ($service, $version) {
                [$dir, $file] = explode(':', $service);
                $version = $version ? '\\' . $version . '\\' : '';
                $class = sprintf($this->dir, $dir, $version, 'Dao', $file);

                return new $class();
            });

            return resolve($service);
        }
    }
}
