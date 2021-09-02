<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UsersController extends AbstractController
{
    /**
     * @Rest\Get(path= "/users", name= "users_list")
     * @view
     */
    public function list(UserRepository $userRepository)
    {
        return $userRepository->findAll();
    }

    /**
     * @Rest\Post(
     *    path = "/users",
     *    name = "user_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function create(User $user)
    {
        $user->setCreatedAt(new DateTimeImmutable());
        // TODO : add the current customer
        // $user->setCustomer();
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @Rest\View(StatusCode = 200)
     * @Rest\Put(
     *     path = "/users/{id}",
     *     name = "user_update",
     *     requirements = {"id"="\d+"}
     * )
     * @ParamConverter("newUser", converter="fos_rest.request_body")
     */
    public function updateAction(User $user, User $newUser)
    {

        $user->setFirstName($newUser->getFirstName());
        $user->setLastName($newUser->getLastName());

        $this->getDoctrine()->getManager()->flush();

        return $user;
    }

    /**
     * @Rest\Get(path="/users/{id}", name ="user_show", requirements = {"id"="\d+"})
     * @view
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * @Rest\Delete(
     *     path = "/users/{id}",
     *     name = "user_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(StatusCode = 204)
     */
    public function delete(User $user)
    {
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        return;
    }
}
