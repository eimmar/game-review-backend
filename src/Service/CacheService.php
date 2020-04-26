<?php

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class CacheService
{
    private TagAwareAdapter $cache;

    private int $cacheLifeTime;

    /**
     * @param int $cacheLifeTime
     * @param string $redisUrl
     */
    public function __construct(int $cacheLifeTime, string $redisUrl)
    {
        $client = RedisAdapter::createConnection(
            $redisUrl,
            [
                'compression' => true,
            ]
        );

        $this->cacheLifeTime = $cacheLifeTime;
        $this->cache = new TagAwareAdapter(new RedisAdapter($client), new RedisAdapter($client));
    }

    /**
     * @param string $tag
     * @param string $key
     * @return string
     */
    private function getCacheKey(string $tag, string $key)
    {
        return preg_replace('/[^a-zA-Z0-9\']/', '_', $tag . '_' . $key);
    }

    public function getItem(string $tag, string $key, $callback, array $arguments)
    {
        $key = $this->getCacheKey($tag, $key);

        return $this->cache->get(
            $key,
            function (ItemInterface $item) use ($tag, $callback, $arguments) {
                $item->expiresAfter($this->cacheLifeTime);
                $item->tag([$tag]);

                return call_user_func_array($callback, $arguments);
            });
    }
}
