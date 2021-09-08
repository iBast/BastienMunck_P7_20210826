<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Repository\UserRepository;
use App\Exception\ResourceValidationException;
use App\Repository\CustomerRepository;
use App\Representation\Users;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UsersController extends AbstractController
{

    /**
     * @Rest\Get(path="/api/users/{id}", name ="user_show", requirements = {"id"="\d+"})
     * @view
     */
    public function show(User $user)
    {
        return $user;
    }


    /**
     * @Rest\Get(path= "/api/users", name= "users_list")
     * 
     *  * @Rest\QueryParam(
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
     *     description="Max number of users per page."
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The requested page"
     * )
     * 
     * @view
     * 
     * @param ParamFetcherInterface $paramFetcher
     * @param UserRepository $userRepository
     * @return Users
     */
    public function list(ParamFetcherInterface $paramFetcher, UserRepository $userRepository, CustomerRepository $customerRepository)
    {
        $client = $customerRepository->find(13);
        //TODO : replace 13 by clientID
        $pager = $userRepository->search(
            $client->getId(),
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('page'),
        );

        return new Users($pager);
    }

    /**
     * @Rest\Post(
     *    path = "/api/users",
     *    name = "user_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function create(User $user)
    {
        if (!$user) {
            throw new ResourceValidationException(
                sprintf('Ressource %d not found')
            );
        }

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
     *     path = "/api/users/{id}",
     *     name = "user_update",
     *     requirements = {"id"="\d+"}
     * )
     * @ParamConverter("newUser", converter="fos_rest.request_body")
     */
    public function updateAction(User $user, User $newUser)
    {
        if ($newUser->getFirstName()) {
            $user->setFirstName($newUser->getFirstName());
        }
        if ($newUser->getLastName()) {
            $user->setLastName($newUser->getLastName());
        }
        if ($newUser->getCustomer()) {
            $user->setCustomer($newUser->getCustomer());
        }

        $this->getDoctrine()->getManager()->flush();

        return $user;
    }

    /**
     * @Rest\Delete(
     *     path = "/api/users/{id}",
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
