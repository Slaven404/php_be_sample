<?php
namespace App;

use GuzzleHttp\Client;
class Provider
{

    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://dummyjson.com/',
            'timeout' => 5.0,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function getAllProducts()
    {
        try {
            $response = $this->client->request('GET', 'products');
            $data = json_decode($response->getBody(), true);

            return $data;

        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function getByIdProducts($id)
    {
        try {
            $response = $this->client->request('GET', "products/{$id}");
            $data = json_decode($response->getBody(), true);

            return $data;

        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }


    public function searchProducts($limit, $skip, $sortBy, $order)
    {

        try {
            $queryParams = [
                'limit' => $limit,
                'skip' => $skip,
                'sortBy' => $sortBy,
                'order' => $order
            ];

            $response = $this->client->request(
                'GET',
                'products',
                [
                    'query' => $queryParams
                ]
            );

            $data = json_decode($response->getBody(), true);

            return $data;

        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }
}