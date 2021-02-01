<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Http\Middleware;

use App\Http\Controllers\Api\Annotation\ResponseFilter;
use Closure;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!empty($request->get('conditions'))) {
            $request->merge(['conditions' => (array) json_decode($request->get('conditions'))]);
        }

        $startTime = microtime(true);
        $response = $next($request);

        $info = $request->method().'  '.$request->ip().'  '.$request->fullUrl().PHP_EOL;
        $info .= 'params:'.json_encode($request->all()).PHP_EOL;
        $info .= 'time:'.(microtime(true) - $startTime).PHP_EOL;
        $info .= 'header:'.json_encode($request->header()).PHP_EOL;
        $info .= 'content:'.$response->getContent().PHP_EOL;
        $info .= str_repeat('----------', 50).PHP_EOL;
        Log::channel('api_info_log')->info($info);

        if (200 != $response->getStatusCode()) {
            Log::channel('api_error_log')->error($info);
        }

        if (200 == $response->getStatusCode()) {
            $this->annotationReader($request, $response);
        }

        return $response;
    }

    protected function annotationReader($request, $response)
    {
        $controller = $request->route()->getController();
        $class = new \ReflectionClass($controller);
        $method = $class->getMethod($request->route()->getActionMethod());
        $reader = new AnnotationReader();
        foreach ($reader->getMethodAnnotations($method) as $annotation) {
            switch (get_class($annotation)) {
                case ResponseFilter::class:
                    return $this->responseFilter($annotation, $response, $request);
                default:
                    return null;
            }
        }
    }

    private function responseFilter($annotation, $response, $request)
    {
        $content = json_decode($response->getContent(), true);
        $class = $annotation->getClass();
        $fieldFilter = new $class();
        $mode = $annotation->getMode();
        if ($mode) {
            $fieldFilter->setMode($mode);
        }

        switch ($request->route()->getActionMethod()) {
            case 'get':
                $data = $fieldFilter->filter($content);
                break;
            case 'search':
                $data = $fieldFilter->filters($content);
                break;
            default:
                $data = $fieldFilter->filter($content);
        }

        if (null !== $data) {
            $response->setContent(json_encode($data));
        }

        return null;
    }
}
