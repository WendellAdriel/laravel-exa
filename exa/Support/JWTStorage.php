<?php

declare(strict_types=1);

namespace Exa\Support;

use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Providers\Storage\Illuminate;

final class JWTStorage extends Illuminate
{
    public function __construct(CacheContract $cache)
    {
        parent::__construct($cache);
        $this->cache = Cache::store('jwt');
    }
}
