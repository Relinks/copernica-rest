<?php

namespace Copernica\Service;

/**
 * Class CopernicaRestApi
 * High-level service class to call specific methods of the Copernica API
 *
 * @package Copernica
 * @todo Implement other API methods as described here: https://www.copernica.com/en/documentation/rest-api
 */
class CopernicaRestApiService extends AbstractCopernicaRestApiService
{
    /**
     * CopernicaRestApiService constructor.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * @return array
     */
    public function getDatabases()
    {
        return $this->get('databases');
    }

    /**
     * @param int   $databaseNumber
     * @param array $data
     *
     * @return mixed
     */
    public function createProfile(int $databaseNumber, array $data)
    {
        return $this->post(sprintf('database/%d/profiles', $databaseNumber), $data);
    }

    /**
     * @param int   $databaseNumber
     * @param array $data
     *
     * @return mixed
     */
    public function putProfile(int $databaseNumber, array $data)
    {
        return $this->put(sprintf('database/%d/profiles', $databaseNumber), $data);
    }
}
