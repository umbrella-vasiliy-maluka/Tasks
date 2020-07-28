<?php

namespace src\Decorator;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\Integration\DataProviderInterface;

abstract class AbstractDecorator implements DataProviderInterface
{
    protected DataProviderInterface $dataProviderInner;
    
    public function __construct( DataProviderInterface $dataProviderInner )
    {
        $this->dataProviderInner = $dataProviderInner;
    }
    
    public function getResponse(array $input): array
    {
        return $this->dataProviderInner->getResponse($input);
    }
}