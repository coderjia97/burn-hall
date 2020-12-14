<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Toolkit;

class FileTools extends App
{
    /**
     * has 判断文件是否存在
     * 2019/10/31 By:Ogg
     *
     * @param string $filename 文件名
     */
    public static function has($filename = ''): bool
    {
        return is_file($filename);
    }

    /**
     * hasFolder 判断文件夹是否存在
     * 2019/10/31 By:Ogg
     *
     * @param string $dir 目录
     */
    public static function hasFolder($dir = ''): bool
    {
        return is_dir($dir);
    }

    /**
     * createFolder 创建目录
     * 2019/10/31 By:Ogg
     *
     * @param string $dir 目录
     */
    public static function createFolder($dir = ''): bool
    {
        if (!$dir || '.' == $dir || './' == $dir) {
            return false;
        }
        if (!self::hasFolder($dir)) {
            return mkdir($dir, 0777, true);
        }

        return false;
    }

    /**
     * write 文件写入
     * 2019/10/31 By:Ogg
     *
     * @param string $filename 文件路径
     * @param string $data     文件写入的内容
     */
    public static function write($filename = '', $data = ''): bool
    {
        $pathInfo = pathinfo($filename);
        $dir = $pathInfo['dirname'];

        if (!self::hasFolder($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        return file_put_contents($filename, $data);
    }

    /**
     * read 文件读取
     * 2019/10/31 By:Ogg
     *
     * @param string $filename 文件路径
     *
     * @return string
     */
    public static function read($filename = '')
    {
        if (self::has($filename)) {
            return file_get_contents($filename);
        }

        return false;
    }

    /**
     * readArray 读取文件内容，将读取的内容放入数组中，每个数组元素为文件的一行，内容包括换行
     * 2019/10/31 By:Ogg
     *
     * @param string $filename 文件路径
     *
     * @return array|bool
     */
    public static function readArray($filename = '')
    {
        if (self::has($filename)) {
            return file($filename);
        }

        return false;
    }

    /**
     * delete 文件删除
     * 2019/10/31 By:Ogg
     *
     * @param string $filename 文件路径
     */
    public static function delete($filename = ''): bool
    {
        if (self::has($filename)) {
            return unlink($filename);
        }
    }

    /**
     * deleteFolder 文件夹删除
     * 2019/10/31 By:Ogg
     *
     * @param string $dir
     */
    public static function deleteFolder($dir = ''): bool
    {
        //先删除目录下的文件：
        if (!self::hasFolder($dir)) {
            return false;
        }

        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ('.' != $file && '..' != $file) {
                $fullPath = $dir.DIRECTORY_SEPARATOR.$file;
                if (!is_dir($fullPath)) {
                    unlink($fullPath);
                } else {
                    self::deleteFolder($fullPath);
                }
            }
        }

        closedir($dh);
        //删除当前文件夹：
        if (rmdir($dir)) {
            return true;
        }

        return false;
    }

    /**
     * copy 拷贝文件或目录
     * 2019/10/31 By:Ogg
     *
     * @param string $new    拷贝目录或者文件
     * @param string $old    目标目录或者文件
     * @param bool   $delete true为删除拷贝目录 false为不删除拷贝目录
     */
    public static function copy(string $new, string $old, $delete = false): bool
    {
        $is = false;

        if (!file_exists($old) && !is_dir($old)) {
            return false;
        }
        $pathInfoNew = pathinfo($new);
        $path = isset($pathInfoNew['extension']) ? $pathInfoNew['dirname'] : $new;
        if (!is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }

        if (is_file($old)) {
            if (!isset($pathInfoNew['extension'])) {
                $pathInfo = pathinfo($old);
                $is = copy($old, $new.DIRECTORY_SEPARATOR.$pathInfo['basename']);
            } else {
                $is = copy($old, $new);
            }
            if (true == $delete) {
                self::delete($old);
            }
        } elseif (!isset($pathInfoNew['extension'])) {
            $dir = scandir($old);
            foreach ($dir as $filename) {
                if (!in_array($filename, ['.', '..'])) {
                    if (is_dir($old.DIRECTORY_SEPARATOR.$filename)) {
                        $is = self::copy($new.DIRECTORY_SEPARATOR.$filename, $old.DIRECTORY_SEPARATOR.$filename, $delete);
                        if (!$is) {
                            return false;
                        }
                        continue;
                    }

                    $is = copy($old.DIRECTORY_SEPARATOR.$filename, $new.DIRECTORY_SEPARATOR.$filename);
                }
            }
        }

        return $is;
    }

    /**
     * findOwn 获取目录下的所有文件路径 包括子目录的文件
     * 2019/10/31 By:Ogg
     *
     * @param string $dir 文件路径
     */
    public static function findOwn($dir = ''): array
    {
        $result = [];
        $handle = opendir($dir);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if ('.' != $file && '..' != $file) {
                    $cur_path = $dir.DIRECTORY_SEPARATOR.$file;
                    if (is_dir($cur_path)) {
                        $files = self::findOwn($cur_path);
                        if ($files) {
                            $result = $result ? array_merge($result, $files) : $files;
                        }
                    } else {
                        $result[] = $cur_path;
                    }
                }
            }
            closedir($handle);
        }

        return $result;
    }
}
