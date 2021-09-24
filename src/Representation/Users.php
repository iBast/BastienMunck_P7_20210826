<?php

namespace App\Representation;

use App\Entity\User;
use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;

class Users extends AbstractRepresentation
{
    /**
     * @Type("ArrayIterator<App\Entity\User>")
     */
    public $data;

    public function __construct(Pagerfanta $data)
    {
        $this->data = $data;

        $this->addCode(200);
        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', iterator_count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('page', $data->getCurrentPage());
    }
}
