<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Toolkit;

class DateTools extends App
{
    /**
     * 获取某个开始时间、结束时间
     * 2019/10/31 By:Ogg
     *
     * @param string $period
     */
    public static function getTimePeriod($period = ''): array
    {
        date_default_timezone_set('Asia/Shanghai');
        [$y, $n, $t, $w, $d] = explode('-', date('Y-n-t-w-d'));
        if (0 == $w) {
            $w = 7;
        }

        $startTime = 0;
        $endTime = PHP_INT_MAX;

        switch ($period) {
            case 'daily':
                //今天
                $startTime = mktime(0, 0, 0, $n, $d, $y);
                $endTime = mktime(23, 59, 59, $n, $d, $y);
                break;
            case 'weekly':
                //本周
                $startTime = mktime(0, 0, 0, $n, $d - $w + 1, $y);
                $endTime = mktime(23, 59, 59, $n, $d - $w + 7, $y);
                break;
            case 'monthly':
                //本月
                $startTime = mktime(0, 0, 0, $n, 1, $y);
                $endTime = mktime(23, 59, 59, $n, $t, $y);
                break;
            case 'quarterly':
                //本季度
                $season = ceil($n / 3) * 3;
                $startTime = mktime(0, 0, 0, $season - 3, 1, $y);
                $endTime = mktime(23, 59, 59, $season, 0, $y);
                break;
            case 'semiAnnual':
                //本半年
                if ($n < 7) {
                    $startTime = mktime(0, 0, 0, 1, 1, $y);
                    $endTime = mktime(23, 59, 59, 6, 30, $y);
                } else {
                    $startTime = mktime(0, 0, 0, 7, 1, $y);
                    $endTime = mktime(23, 59, 59, 12, 31, $y);
                }
                break;
            case 'annual':
                //本年
                $startTime = mktime(0, 0, 0, 1, 1, $y);
                $endTime = mktime(23, 59, 59, 12, 31, $y);
                break;
        }

        return [$startTime, $endTime];
    }

    /**
     * 返回今日开始和结束的时间戳
     * 2019/10/31 By:Ogg
     */
    public static function today(): array
    {
        [$y, $m, $d] = explode('-', date('Y-m-d'));

        return [
            mktime(0, 0, 0, $m, $d, $y),
            mktime(23, 59, 59, $m, $d, $y),
        ];
    }

    /**
     * 返回昨日开始和结束的时间戳
     * 2019/10/31 By:Ogg
     */
    public static function yesterday(): array
    {
        $yesterday = date('d') - 1;

        return [
            mktime(0, 0, 0, date('m'), $yesterday, date('Y')),
            mktime(23, 59, 59, date('m'), $yesterday, date('Y')),
        ];
    }

    /**
     * 返回本周开始和结束的时间戳
     * 2019/10/31 By:Ogg
     */
    public static function week(): array
    {
        [$y, $m, $d, $w] = explode('-', date('Y-m-d-w'));
        if (0 == $w) {
            $w = 7;
        } //修正周日的问题
        return [
            mktime(0, 0, 0, $m, $d - $w + 1, $y), mktime(23, 59, 59, $m, $d - $w + 7, $y),
        ];
    }

    /**
     * 返回上周开始和结束的时间戳
     * 2019/10/31 By:Ogg
     */
    public static function lastWeek(): array
    {
        $timestamp = time();

        return [
            strtotime(date('Y-m-d', strtotime('last week Monday', $timestamp))),
            strtotime(date('Y-m-d', strtotime('last week Sunday', $timestamp))) + 24 * 3600 - 1,
        ];
    }

    /**
     * 返回本月开始和结束的时间戳
     * 2019/10/31 By:Ogg
     *
     * @param bool $everyDay
     */
    public static function month($everyDay = false): array
    {
        [$y, $m, $t] = explode('-', date('Y-m-t'));

        return [
            mktime(0, 0, 0, $m, 1, $y),
            mktime(23, 59, 59, $m, $t, $y),
        ];
    }

    /**
     * 返回上个月开始和结束的时间戳
     * 2019/10/31 By:Ogg
     */
    public static function lastMonth(): array
    {
        $y = date('Y');
        $m = date('m');
        $begin = mktime(0, 0, 0, $m - 1, 1, $y);
        $end = mktime(23, 59, 59, $m - 1, date('t', $begin), $y);

        return [$begin, $end];
    }

    /**
     * 返回今年开始和结束的时间戳
     * 2019/10/31 By:Ogg
     */
    public static function year(): array
    {
        $y = date('Y');

        return [
            mktime(0, 0, 0, 1, 1, $y),
            mktime(23, 59, 59, 12, 31, $y),
        ];
    }

    /**
     * 返回去年开始和结束的时间戳
     * 2019/10/31 By:Ogg
     */
    public static function lastYear(): array
    {
        $year = date('Y') - 1;

        return [
            mktime(0, 0, 0, 1, 1, $year),
            mktime(23, 59, 59, 12, 31, $year),
        ];
    }

    /**
     * 获取几天前零点到现在/昨日结束的时间戳
     * 2019/10/31 By:Ogg
     *
     * @param int  $day 天数
     * @param bool $now 返回现在或者昨天结束时间戳
     */
    public static function dayToNow($day = 1, $now = true): array
    {
        $end = time();
        if (!$now) {
            [$foo, $end] = self::yesterday();
        }

        return [
            mktime(0, 0, 0, date('m'), date('d') - $day, date('Y')),
            $end,
        ];
    }

    /**
     * 返回几天前的时间戳
     * 2019/10/31 By:Ogg
     *
     * @param int $day
     *
     * @return int
     */
    public static function daysAgo($day = 1)
    {
        $nowTime = time();

        return $nowTime - self::daysToSecond($day);
    }

    /**
     * 返回几天后的时间戳
     * 2019/10/31 By:Ogg
     *
     * @param int $day
     *
     * @return int
     */
    public static function daysAfter($day = 1)
    {
        $nowTime = time();

        return $nowTime + self::daysToSecond($day);
    }

    /**
     * 天数转换成秒数
     * 2019/10/31 By:Ogg
     *
     * @param int $day
     *
     * @return int
     */
    public static function daysToSecond($day = 1)
    {
        return $day * 86400;
    }

    /**
     * 周数转换成秒数
     * 2019/10/31 By:Ogg
     *
     * @param int $week
     *
     * @return int
     */
    public static function weekToSecond($week = 1)
    {
        return self::daysToSecond() * 7 * $week;
    }
}
