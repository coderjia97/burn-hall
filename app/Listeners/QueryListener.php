<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

class QueryListener
{
    private $slowTime = 3 * 1000;

    public function __construct()
    {
    }

    public function handle(QueryExecuted $event)
    {
        $sql = vsprintf(str_replace('?', "'%s'", $event->sql), $event->bindings);

        Log::channel('sql')->info($sql);

        if ($event->time > $this->slowTime) {
            Log::channel('slow_sql')->info($sql);
        }
    }
}
