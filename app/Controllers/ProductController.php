<?php

namespace App\Controllers;
use App\Provider;
use App\Parser;
class ProductController
{
    private $provider;
    private $parser;

    public function __construct()
    {
        $this->provider = new Provider();
        $this->parser = new Parser();
    }


    public function getAllProducts(): array
    {
        $result = $this->provider->getAllProducts();
        $data = $this->parser->parseProductList(($result));
        return $data;

    }

    public function getByIdProducts($id)
    {
        $result = $this->provider->getByIdProducts($id);
        $data = $this->parser->parseProduct($result);
        return $data;
    }

    public function searchProducts($limit, $skip, $sortBy, $order)
    {
        $result = $this->provider->searchProducts($limit, $skip, $sortBy, $order);
        $data = $this->parser->parseProductList(($result));
        return $data;
    }
}