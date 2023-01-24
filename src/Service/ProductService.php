<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class ProductService
{
    private FilesystemAdapter $cache;
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->cache = new FilesystemAdapter();
        $this->productRepository = $productRepository;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getProductsCache()
    {
        $value = $this->cache->get('team_key', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            $products = $this->productRepository->findBy(
                array(),
                array('created_at' => 'ASC')
            );
            return $products;
        });
        $this->cache->delete('team_key');
        return $value;
    }
}
