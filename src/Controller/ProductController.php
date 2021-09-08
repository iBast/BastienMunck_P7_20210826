<?php

namespace App\Controller;

use App\Entity\Product;
use App\Representation\Products;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    /**
     * @Rest\Get(path="/products/{id}", name ="product_show", requirements = {"id"="\d+"})
     * @view
     * 
     * @param Product $product
     * @return Product
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * @Rest\Get(path= "/products", name= "product_list")
     * 
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="desc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="5",
     *     description="Max number of products per page."
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The requested page"
     * )
     * @view
     * 
     * @param ParamFetcherInterface $paramFetcher
     * @param ProductRepository $productRepository
     * @return Products

     */
    public function list(ParamFetcherInterface $paramFetcher, ProductRepository $productRepository)
    {
        $pager = $productRepository->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('page')
        );



        return new Products($pager);
    }
}
