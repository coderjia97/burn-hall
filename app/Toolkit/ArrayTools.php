<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Toolkit;

class ArrayTools extends App
{
    /**
     * 判断数组键是否存在
     * 2019/10/31 By:Ogg
     *
     * @param bool $strictMode true 严格模式 判断是否为null|''|0
     * @param bool $tips true 提示某个字段不存在
     *
     * @return array|bool
     */
    public static function requires(array $array, array $keys, $strictMode = false, $tips = false)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                return $tips ? [false, $key] : false;
            }
            if ($strictMode && (is_null($array[$key]) || '' === $array[$key] || 0 === $array[$key])) {
                return $tips ? [false, $key] : false;
            }
        }

        return true;
    }

    /**
     * 添加字段 level
     * 2019/10/31 By:Ogg
     *
     * @param $array
     */
    public static function arrayInLaravel($array, int $pid = 0, int $level = 1, int $toLaravel = 999): array
    {
        static $list = [];
        foreach ($array as $v) {
            if ($v['pId'] == $pid && $level <= $toLaravel) {
                $v['level'] = $level;
                $list[] = $v;
                self::arrayInLaravel($array, $v['id'], $level + 1, $toLaravel);
            }
        }

        return $list;
    }

    /**
     * 子元素计算器
     * 2019/10/31 By:Ogg
     *
     * @param $array
     * @param $pId
     */
    public static function childrenCount($array, $pId): array
    {
        $counter = [];
        foreach ($array as $item) {
            $count = $counter[$item[$pId]] ?? 0;
            ++$count;
            $counter[$item[$pId]] = $count;
        }

        return $counter;
    }

    /**
     * 把元素插入到对应的父元素$childKeyName字段
     * 2019/10/31 By:Ogg
     *
     * @param $parent
     * @param $pid
     * @param $child
     * @param $childKeyName
     *
     * @return mixed
     */
    public static function childAppend($parent, $pid, $child, $childKeyName)
    {
        foreach ($parent as &$item) {
            if ($item['id'] == $pid) {
                if (!isset($item[$childKeyName])) {
                    $item[$childKeyName] = [];
                }
                $item[$childKeyName][] = $child;
            }
        }

        return $parent;
    }

    public static function index(array $array, $name): array
    {
        $indexedArray = [];

        if (empty($array)) {
            return $indexedArray;
        }

        foreach ($array as $item) {
            if (isset($item[$name])) {
                $indexedArray[$item[$name]] = $item;
                continue;
            }
        }

        return $indexedArray;
    }

    public static function removeNull(array $array): array
    {
        if (empty($array)) {
            return [];
        }

        foreach ($array as $key => $value) {
            if (empty($array[$key]) || '' == $array[$key] || null == $array[$key]) {
                unset($array[$key]);
            }
        }

        return $array;
    }

    public static function parts(array $array, array $keys)
    {
        foreach (array_keys($array) as $key) {
            if (!in_array($key, $keys)) {
                unset($array[$key]);
            }
        }

        return $array;
    }

    public static function requireds(array $array, array $keys, $strictMode = false)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                return false;
            }
            if ($strictMode && (is_null($array[$key]) || $array[$key] === '' || $array[$key] === 0)) {
                return false;
            }
        }

        return true;
    }
}
