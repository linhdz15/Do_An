<?php

namespace App\Concern;

use Closure;
use InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    /**
     * Hashing algorithm for the key.
     * @var string
     */
    protected $hash_algo = 'sha256';

    /**
     * Return a cached object or store the result of the closure with an autogenerated key.
     *
     * @param \Closure $function
     *
     * @return mixed
     */
    protected function remember(Closure $function)
    {
        $previous_call = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1];

        $data = [
            'class'    => $previous_call['class'],
            'function' => $previous_call['function'],
            'args'     => $previous_call['args'],
            'commit'   => config('cache.commit'),
        ];

        $key  = $this->generateCacheKey($data);

        return Cache::remember($key, $this->getTTL(), $function);
    }

    /**
     * Allow a per-class config of TTL or use the application default value.
     *
     * @return float|int
     */
    protected function getTTL()
    {
        return Cache::getDefaultCacheTime();
    }

    /**
     * Stop the execution if there is a Closure in the argument list.
     *
     * @param $arguments
     */
    protected function checkArguments($arguments)
    {
        foreach ($arguments as $key => $arg) {
            if ($arg instanceof Closure) throw new InvalidArgumentException('Closure can\'t be serialized');
            $arguments[$key] = ($arg instanceof Request) ? $arg->all() : $arg;
        }

        return $arguments;
    }

    /**
     * Generate the cache key based on: Class, Function, Arguments, Git commit.
     * Using serialize allow the caching of custom objects.
     *
     * @param $previous_call
     *
     * @return mixed
     */
    protected function generateCacheKey($data)
    {
        $data['args'] = $this->checkArguments($data['args']);

        $key = hash($this->hash_algo, serialize([
            $data['class'],
            $data['function'],
            $data['args'],
            $data['commit'],
        ]));

        return $key;
    }
}
