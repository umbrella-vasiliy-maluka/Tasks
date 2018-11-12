<?php

interface DataProviderInterface {
    /**
     * Returns a response from external service
     * @param array $request
     *
     * @return array
     */
    public function get(array $request);
}