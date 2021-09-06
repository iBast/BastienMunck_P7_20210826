<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    /**
     * @Rest\Get(path= "/products", name= "product_list")
     * @view
     */
    public function list(ProductRepository $productRepository)
    {
        return $productRepository->findAll();
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
