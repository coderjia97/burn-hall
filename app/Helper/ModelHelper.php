<?php

namespace App\Helper;

class ModelHelper
{
    protected $dir = '\App\Models\%s%s\%s\%s';

    public function createModelService($service, $version = '')
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

    public function createModelDao($service, $version = '')
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

    public function transformArray($query): array
    {
        if (null === $query) {
            return [];
        }

        return $query->toArray();
    }
}
