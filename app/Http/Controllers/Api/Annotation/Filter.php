<?php

namespace App\Http\Controllers\Api\Annotation;

use App\Toolkit\ArrayTools;

abstract class Filter
{
    /**
     * 简化模式
     */
    public const SIMPLE_MODE = 'simple';

    protected $mode = self::SIMPLE_MODE;

    public function setMode($mode): void
    {
        $this->mode = $mode;
    }

    public function filter($data): ?array
    {
        if (!$data) {
            return null;
        }

        foreach ([self::SIMPLE_MODE] as $mode) {
            $property = $mode.'Fields';
            if (property_exists($this, $property) && $this->{$property}) {
                $data = ArrayTools::parts($data, $this->$property);
                if (method_exists($this, $property)) {
                    $data = $this->$property($data);
                }
            }
        }

        return $data;
    }

    public function filters(&$dataSet): ?array
    {
        if (!$dataSet) {
            return null;
        }

        if (array_key_exists('data', $dataSet) && array_key_exists('paging', $dataSet)) {
            foreach ($dataSet['data'] as &$data) {
                $data = $this->filter($data);
            }
        } else {
            foreach ($dataSet as &$data) {
                $data = $this->filter($data);
            }
        }

        return $dataSet;
    }

    protected function getService($service)
    {
        return app('modelHelper')->getService($service);
    }
}
