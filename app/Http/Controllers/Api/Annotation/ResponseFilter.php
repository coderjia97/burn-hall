<?php

namespace App\Http\Controllers\Api\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class ResponseFilter
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $mode;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst(str_replace('_', '', $key));
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(sprintf('Unknown property "%s" on annotation "%s".', $key, get_class($this)));
            }
            $this->$method($value);
        }
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }
}
