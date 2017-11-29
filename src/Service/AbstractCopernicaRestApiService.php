<?php

namespace Copernica\Service;

/**
 * Class AbstractCopernicaRestApiService
 * Low-level service class to communicate directly with the Copernica API.
 * This class should not be instantiated directly, only extending classes should be instantiated
 * @package Copernica
 */
class AbstractCopernicaRestApiService
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $url = 'https://api.copernica.com/v1';

    /**
     * CopernicaRestApi constructor.
     *
     * @param string $token
     */
    protected function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @param string $uri
     * @param array  $curlOptions
     *
     * @return mixed
     */
    private function request(string $uri, array $curlOptions = [])
    {
        // Create cURL resource
        $url = sprintf('%s%s', $this->url, $uri);
        $curl = curl_init($url);

        // Set cURL options
        if (count($curlOptions)) {
            curl_setopt_array($curl, $curlOptions);
        }

        // Execute request
        $response = curl_exec($curl);

        // Close cURL resource
        curl_close($curl);

        return $response;
    }

    /**
     * @param string $resource
     * @param array  $parameters
     *
     * @return array
     */
    protected function get(string $resource, array $parameters = [])
    {
        // Build the URI
        $uri = sprintf('/%s?%s', $resource, http_build_query(['access_token' => $this->token] + $parameters));

        // Build cURL options
        $curlOptions = [
            CURLOPT_RETURNTRANSFER => true
        ];

        // Execute request and get response
        $response = $this->request($uri, $curlOptions);

        return json_decode($response, true);
    }

    /**
     * @param string $resource
     * @param array  $data
     *
     * @return mixed
     */
    protected function post(string $resource, array $data = [])
    {
        // Build the URI
        $uri = sprintf('/%s?%s', $resource, http_build_query(['access_token' => $this->token]));

        // Build cURL options
        $encodedData = json_encode($data);
        $curlOptions = [
            CURLOPT_POST => true,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => $encodedData,
        ];

        // Execute request and get response
        $response = $this->request($uri, $curlOptions);

        if (!$response) {
            return false;
        }

        // Try and get the X-Created id from the header
        if (!preg_match('/X-Created:\s?(\d+)/i', $response, $matches)) {
            return true;
        }

        // Return the ID of the created item
        return $matches[1];
    }

    /**
     * @param string $resource
     * @param array  $data
     * @param array  $parameters
     *
     * @return mixed
     */
    protected function put(string $resource, array $data = [], array $parameters = [])
    {
        // Build the URI
        $uri = sprintf('/%s?%s', $resource, http_build_query(['access_token' => $this->token] + $parameters));

        // Build cURL options
        $encodedData = json_encode($data);
        $curlOptions = [
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Content-Length: ' . strlen($encodedData)],
            CURLOPT_POSTFIELDS => $encodedData,
        ];

        // Execute request and get response
        $response = $this->request($uri, $curlOptions);

        return $response;
    }

    /**
     * @param string $resource
     *
     * @return mixed
     */
    protected function delete(string $resource)
    {
        // Build the URI
        $uri = sprintf('/%s?%s', $resource, http_build_query(['access_token' => $this->token]));

        // Build cURL options
        $curlOptions = [
            CURLOPT_CUSTOMREQUEST => 'DELETE',
        ];

        // Execute request and get response
        $response = $this->request($uri, $curlOptions);

        return $response;
    }
}
