<?php

namespace src\Decorator;

use \Psr\Cache\CacheItemPoolInterface;
use \Psr\Log\LoggerInterface;
use src\Integration\DataProvider;
use src\Integration\DataProviderInterface;

final class CacheDataProvider extends AbstractDecorator
{
    private const TTL = '+1 day';
    
    private LoggerInterface $logger;
    private CacheItemPoolInterface $cache;
    
    /**
     * CacheDataProvider constructor.
     *
     * @param DataProviderInterface $dataProviderInner
     * @param LoggerInterface $logger
     * @param CacheItemPoolInterface $cache
     */
    public function __construct( DataProviderInterface $dataProviderInner, LoggerInterface $logger, CacheItemPoolInterface $cache ) {
        parent::__construct( $dataProviderInner );
        
        $this->cache = $cache;
        $this->logger = $logger;
    }
    
    /**
     * @param array $input
     *
     * @return array
     * @throws \Exception
     */
    public function getResponse( array $input ): array {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }
        
            $result = parent::getResponse($input);
            
            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new \DateTime())->modify(self::TTL)
                );
        
            return $result;
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        
            throw $e;
        }
    }
    
    /**
     * @param array $input
     *
     * @return false|string
     */
    public function getCacheKey(array $input)
    {
        return json_encode($input);
    }
}