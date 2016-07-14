<?php

namespace Pixelpub\Loco;

use Illuminate\Support\Facades\Cache;

class Loco implements LocoContract
{
    /**
     * A string that should be prepended to cache kys.
     */
    const CACHE_PREFIX = 'LOCO';

    /**
     * localise.biz api url.
     *
     * @var string
     */
    protected $api;

    /**
     * Available projects.
     *
     * @var array
     */
    protected $projects;

    /**
     * @var string
     */
    protected $index;

    /**
     * @var string
     */
    protected $cache;

    /**
     * Available languages.
     *
     * @var array
     */
    protected $languages;

    /**
     * Loco constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->api = $config['api'];
        $this->projects = $config['projects'];
        $this->index = $config['loco_index'];
        $this->cache = $config['cache'];
        $this->languages = $config['languages'];
    }

    /**
     * Get assets from cache. If, for the very first time,
     * items are not available in the specified cache, load
     * assets from api url and store into cache.
     *
     * @param $project
     * @param $language
     * @return mixed
     */
    public function export($project, $language)
    {
        $cacheKey = $this->buildCacheKey($project, $language);
        return Cache::rememberForever($cacheKey, function () use ($project, $language) {
            return $this->getLocoAssets($project, $language);
        });
    }

    /**
     * Flush all cached language objects from project and
     * refill cache with fresh assets. Try to load asset from
     * loco before flushing cache. If loco api is not available,
     * keep legacy assets in cache and throw exception.
     *
     * @param $project
     */
    public function flush($project)
    {
        foreach ($this->languages as $language) {
            $assets = $this->getLocoAssets($project, $language);

            if (false === $assets) {
                throw new \Exception('Could not load assets from "' . $this->api . '"".');
            }

            Cache::forget($this->buildCacheKey($project, $language));
            $cacheKey = $this->buildCacheKey($project, $language);
            Cache::rememberForever($cacheKey, function () use ($assets) {
                return $assets;
            });
        }
    }

    /**
     * Generate unique cache key.
     *
     * @param $project
     * @param $language
     * @return string
     */
    protected function buildCacheKey($project, $language)
    {
        return self::CACHE_PREFIX . $project . $language;
    }

    /**
     * Get loco api key from config array.
     *
     * @param $project
     * @return string|mixed
     * @throws \Exception
     */
    protected function getApiKey($project)
    {
        if (!array_key_exists($project, $this->projects)) {
            throw new \Exception('Project with name "' . $project . '" is not configured in config/loco.php.');
        }

        return $this->projects[$project];
    }

    /**
     * Fetch loco assets from url.
     *
     * @param $project
     * @param $language
     * @return bool|string
     */
    protected function getLocoAssets($project, $language)
    {
        $requestUrl = $this->api . $language . '.json?key=' . $this->getApiKey($project) . '&index=' . $this->index;
        return file_get_contents($requestUrl);
    }
}