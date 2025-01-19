<?php

namespace App;

class Parser
{
    public function parseProductList($response): array
    {

        if (!isset($response['products'], $response['total'], $response['limit'], $response['skip'])) {
            [];
        }

        if (is_array($response) && isset($response['products'])) {
            $meta = [
                "total_pages" => ceil($response['total'] / $response['limit']),
                "page" => $response['skip'] + 1,
                "per_page" => $response['limit'],
            ];


            $data = array_map(function ($product) {
                return $this->mapProducts($product);

            }, $response['products']);


            return ["data" => $data, "meta" => $meta];
        }
        return [];
    }

    public function parseProduct($product)
    {
        return [
            'id' => $product['id'] ?? null,
            'title' => $product['title'] ?? '',
            'description' => $product['description'] ?? '',
            'category' => $product['category'] ?? '',
            'tags' => implode(", ", $product['tags']) ?? '',
            'price' => $this->formatPrice($product['price'] ?? 0),
            'stock' => $this->resolveStock($product['stock'] ?? 0),
            'thumbnail' => $product['thumbnail'] ?? '',
        ];
    }

    private function mapProducts(array $product): array
    {
        return [
            'id' => $product['id'] ?? null,
            'title' => $product['title'] ?? '',
            'description' => $product['description'] ?? '',
            'short_description' => isset($product['description']) ? substr($product['description'], 0, 30) : '',
            'price' => $this->formatPrice($product['price'] ?? 0),
            'stock' => $this->resolveStock($product['stock'] ?? 0),
            'thumbnail' => $product['thumbnail'] ?? '',
        ];
    }

    private function resolveStock(int $stock): string
    {
        if ($stock == 0) {
            return "No stock";
        }

        if ($stock < 5) {
            return "Get it while you can";
        }

        return "On stock";
    }

    private function formatPrice($price)
    {
        $formatter = new \NumberFormatter('de_DE', \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($price, 'EUR');

    }


}