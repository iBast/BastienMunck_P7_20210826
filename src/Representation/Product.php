<?php

namespace App\Representation;

use Pagerfanta\Pagerfanta;
use App\Entity\Product as Entity;
use JMS\Serializer\Annotation\Type;


class Product extends AbstractRepresentation
{


    public $data;

    public function __construct(Entity $product)
    {
        $this->data = $product;
        $this->addCode(200);
    }
}
