<?php

namespace App\Controller;

use App\Entity\Product;
use App\Representation\Products;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;


class ProductController extends AbstractController
{
    /**
     * @Rest\Get(path="/api/products/{id}", name ="product_show", requirements = {"id"="\d+"})
     * 
     * @OA\Response(response=200, description="Returns the details of one product")
     * @OA\Response(response=400, description="Resource is not found")
     * @OA\Response(response=401, description="Invalid JWT token.")
     * 
     * @Cache(expires="tomorrow", public=true)
     * 
     * @OA\Tag(name="Product")
     * 
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
     * @Rest\Get(path= "/api/products", name= "product_list")
     * 
     * @OA\Response(response=200, description="Returns the list of products")
     * @OA\Response(response=401, description="Invalid JWT token.")
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
     * 
     * @Cache(expires="tomorrow", public=true)
     * 
     * @OA\Tag(name="Product")
     * 
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
