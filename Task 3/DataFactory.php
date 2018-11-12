<?php

class DataFactory
{
    private $cache;
    private $logger;
    private $provider;
    
    const TTL = '+1 day';
    
    /**
     * @param array $providerParams
     * @param DataProviderInterface $provider
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(array $providerParams, DataProviderInterface $provider, CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        $this->provider = new $provider($providerParams);
        $this->cache = $cache;
        $this->logger = $logger;
    }
    
    /**
     * Get result from cache or API.
     * @param array $request
     *
     * @return array
     */
    public function getResponse(array $request)
    {
        try {
            $cacheKey = $this->getCacheKey($request);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
            
            $result = $this->provider->get($request);
            
            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new \DateTime())->modify(self::TTL)
                );
            
            return $result;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
        
        return [];
    }
    
    protected function getCacheKey(array $input)
    {
        return json_encode($input);
    }
}