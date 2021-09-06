<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    /**
     * @Rest\Get(path= "/products", name= "product_list")
     * @view
     */
    public function list(ParamFetcherInterface $paramFetcher, ProductRepository $productRepository)
    {
        $pager = $productRepository->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return $pager->getCurrentPageResults();
    }

    /**
     * @Rest\Get(path="/products/{id}", name ="product_show", requirements = {"id"="\d+"})
     * @view
     */
    public function show(Product $product)
    {
        return $product;
    }
}
