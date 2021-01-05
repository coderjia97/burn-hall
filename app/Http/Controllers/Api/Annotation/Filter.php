<?php

namespace App\Http\Controllers\Api\Annotation;

use App\Toolkit\ArrayTools;

abstract class Filter
{
    /**
     * 简化模式
     */
    const SIMPLE_MODE = 'simple';

    protected $mode = self::SIMPLE_MODE;

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function filter($data)
    {
        if (!$data) {
            return json_encode([]);
        }
        $data = json_decode($data, true);

        foreach ([self::SIMPLE_MODE] as $mode) {
            $property = $mode.'Fields';
            if (property_exists($this, $property) && $this->{$property}) {
                $data = ArrayTools::parts($data, $this->$property);
                if (method_exists($this, $property)) {
                    $data = $this->$property($data);
                }
            }
        }

        return json_encode($data);
    }

//    public function filters(&$dataSet)
//    {
//        if (!$dataSet) {
//            return;
//        }
//
//        if (array_key_exists('data', $dataSet) && array_key_exists('paging', $dataSet)) {
//            foreach ($dataSet['data'] as &$data) {
//                $this->filter($data);
//            }
//        } else {
//            foreach ($dataSet as &$data) {
//                $this->filter($data);
//            }
//        }
//    }
}
