<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Toolkit;

class CharTools extends App
{
    /**
     * 随机生成字符串
     * 2019/10/31 By:Ogg
     *
     * @param $len
     */
    public static function getRandChar($len): string
    {
        $a = range('a', 'z');
        $b = range('A', 'Z');
        $c = range('0', '9');
        $chars = array_merge($a, $b, $c);
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = '';
        for ($i = 0; $i < $len; ++$i) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }

        return $output;
    }

    /**
     * 生成GUID
     * 2019/10/31 By:Ogg
     */
    public static function generateGuid(): string
    {
        mt_srand((float) microtime() * 10000);
        $charId = strtoupper(md5(uniqid(mt_rand(), true)));
        $uuid = substr($charId, 0, 8).substr($charId, 8, 4).substr($charId, 12, 4).substr($charId, 16, 4).substr($charId, 20, 12);

        return strtolower($uuid);
    }
}
