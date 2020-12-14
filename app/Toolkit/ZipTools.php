<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Toolkit;

class ZipTools extends App
{
    public $zip;
    public $file;

    /**
     * 初始化函数
     * 2019/10/31 By:Ogg
     */
    public function __construct()
    {
        $this->zip = new \ZipArchive();
        $this->file = new FileTools();
    }

    /**
     * add_file 压缩单个文件
     * 2019/10/31 By:Ogg
     *
     * @param string $filename    被压缩的文件
     * @param null   $zipFilename string 在压缩文件中的文件名称，如果不设置为压缩文件的名称，默认不设置
     *
     * @return int 1 or 0
     */
    public function addFile(string $filename, $zipFilename = null): int
    {
        if ($zipFilename) {
            return $this->zip->addFile($filename, $zipFilename);
        }

        return $this->zip->addFile($filename);
    }

    /**
     * zip 压缩整个目录
     * 2019/10/31 By:Ogg
     *
     * @param $dir string  压缩目录路径
     * @param string $zipFilename
     *
     * @return int 1 or 0
     */
    public function zip(string $dir, $zipFilename = 'zip.zip'): ?int
    {
        $pathInfo = pathinfo($zipFilename);

        if ($this->file->createFolder($pathInfo['dirname'])) {
            if (true === $this->zip->open($zipFilename, \ZipArchive::CREATE)) { ///ZipArchive::OVERWRITE 如果文件存在则覆盖
                $this->createZip($dir);
            }

            return $this->zip->close();
        }
    }

    /**
     * unzip 解压缩文件
     * 2019/10/31 By:Ogg
     *
     * @param string $zipFilename 解压缩的文件
     * @param string $path        解压厚的路径
     *
     * @return int 1 or 0
     */
    public function unzip($zipFilename = 'zip.zip', $path = '')
    {
        if (true === $this->zip->open($zipFilename)) {
            $file_tmp = @fopen($zipFilename, 'rb');
            $bin = fread($file_tmp, 15); //只读15字节 各个不同文件类型，头信息不一样。
            fclose($file_tmp);
            /* 只针对zip的压缩包进行处理 */
            if (true === $this->getTypeList($bin)) {
                $result = $this->zip->extractTo($path);
                $this->zip->close();

                return $result;
            }
        }

        return false;
    }

    /**
     * add_file 添加目录到zip对象
     * 2019/10/31 By:Ogg
     *
     * @param string $dir    压缩目录路径
     * @param null   $parent 压缩文件的文件名，包括路径
     *
     * @return bool
     */
    public function createZip(string $dir, $parent = null): ?bool
    {
        $handle = opendir($dir);
        if ($handle) {
            try {
                while (false !== ($file = readdir($handle))) {
                    if ('.' != $file && '..' != $file) {
                        $curPath = $dir.DIRECTORY_SEPARATOR.$file;
                        if (is_dir($curPath)) {
                            $parentParam = $parent ? $parent.'/'.$file : $file;
                            $this->createZip($curPath, $parentParam);
                        } else {
                            $filenameZip = $parent ? $parent.'/'.$file : $file;
                            $this->addFile($curPath, $filenameZip);
                        }
                    }
                }
                closedir($handle);

                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    /**
     * get_list 获取压缩文件的列表
     * 2019/10/31 By:Ogg
     *
     * @param string $zipFilename 压缩文件
     */
    public function getList($zipFilename = 'zip.zip'): array
    {
        $file_dir_list = [];
        $file_list = [];
        if (true == $this->zip->open($zipFilename)) {
            for ($i = 0; $i < $this->zip->numFiles; ++$i) {
                $numFiles = $this->zip->getNameIndex($i);
                if (preg_match('/\/$/i', $numFiles)) {
                    $file_dir_list[] = $numFiles;
                } else {
                    $file_list[] = $numFiles;
                }
            }
        }

        return ['files' => $file_list, 'dirs' => $file_dir_list];
    }
}
