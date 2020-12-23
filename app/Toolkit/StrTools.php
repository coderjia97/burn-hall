<?php
/**
 * Sunny 2020/12/23 下午2:46
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Toolkit;

class StrTools extends App
{
    /**
     * 检查字符串中是否包含某些字符串
     * 2019/10/31 By:Ogg
     *
     * @param string|array $needles
     */
    public static function contains(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ('' != $needle && false !== mb_strpos($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 检查字符串是否以某些字符串结尾
     * 2019/10/31 By:Ogg
     *
     * @param string|array $needles
     */
    public static function endsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === static::substr($haystack, -static::length($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * 检查字符串是否以某些字符串开头
     * 2019/10/31 By:Ogg
     *
     * @param string|array $needles
     */
    public static function startsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ('' != $needle && 0 === mb_strpos($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 下划线转驼峰
     *
     * @param $str
     *
     * @return string|string[]|null
     */
    public static function convertUnderline($str)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $str);

        return $str;
    }
}
