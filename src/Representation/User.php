<?php

namespace App\Representation;

use Pagerfanta\Pagerfanta;
use App\Entity\User as Entity;
use JMS\Serializer\Annotation\Type;


class User extends AbstractRepresentation
{


    public $data;

    public function __construct(Entity $user)
    {
        $this->data = $user;
        $this->addCode(200);
    }
}
