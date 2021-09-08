<?php

namespace App\Representation;

use App\Entity\Product;
use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;


class Products extends AbstractRepresentation
{

    /**
     * @Type("ArrayIterator<App\Entity\Product>")
     */
    public $data;

    public function __construct(Pagerfanta $data)
    {
        $this->data = $data;

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', iterator_count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('page', $data->getCurrentPage());
    }
}
