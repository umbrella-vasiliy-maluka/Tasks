<?php

/**
 * DataProvider for `Test` service
 * Class TestDataProvider
 */
class TestDataProvider implements ProviderInterface
{
    private $host;
    private $user;
    private $password;
    
    /**
     * @param $params - API connection parameters
     */
    public function __construct(array $params)
    {
        $this->host = $params['host'];
        $this->user = $params['user'];
        $this->password = $params['password'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function get(array $request)
    {
        // returns a response from external service
    }
}