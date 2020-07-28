<?php

namespace src\Integration;

/**
 * "Some Service"
 * Class ServiceDataProvider
 * @package src\Integration
 */
class ServiceDataProvider implements DataProviderInterface
{
    private string $host;
    private string $user;
    private string $password;
    
    /**
     * @param string $host
     * @param string $user
     * @param string $password
     */
    public function __construct(string $host, string $user, string $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }
    
    /**
     * @param array $request
     *
     * @return array
     */
    public function getResponse(array $request): array
    {
        // returns a response from external service
    }
}