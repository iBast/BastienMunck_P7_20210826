<?php

namespace App\Controller;

use App\Entity\User;
use App\Representation\User as Representation;
use App\Manager\UserManager;
use App\Representation\Users;
use OpenApi\Annotations as OA;
use App\Repository\UserRepository;
use App\Exception\ResourceValidationException;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UsersController extends AbstractController
{
    protected $manager;

    public function __construct(UserManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Rest\Get(path="/api/users/{id}", name ="user_show", requirements = {"id"="\d+"})
     * 
     * @OA\Response(response=200, description="Returns the details of one user")
     * @OA\Response(response=404, description="Resource is not found")
     * @OA\Response(response=401, description="Invalid JWT token.")
     * @OA\Response(response=403, description="Access denied - the ressource is not belonging to your company")
     * 
     * @OA\Tag(name="User")
     * 
     * @view
     */
    public function show(User $user)
    {
        if ($user->getCustomer() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        return new Representation($user);
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
     * @OA\Response(response=200, description="Returns the list of users")
     * @OA\Response(response=401, description="Invalid JWT token.")
     * 
     * @view(StatusCode = 200)
     * 
     * @OA\Tag(name="User")
     * 
     * @param ParamFetcherInterface $paramFetcher
     * @param UserRepository $userRepository
     * @return Users
     */
    public function list(ParamFetcherInterface $paramFetcher, UserRepository $userRepository)
    {
        $customer = $this->getUser();
        $pager = $userRepository->search(
            $customer->getId(),
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('page')
        );

        return new Users($pager);
    }

    /**
     * @Rest\Post(
     *    path = "/api/users",
     *    name = "user_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @Rest\RequestParam(
     *   name="first_name",
     *   key=null,
     *   requirements="",
     *   default=null,
     *   description="The company user first name",
     *   strict=true,
     *   map=false,
     *   nullable=false
     * )
     * @Rest\RequestParam(
     *   name="last_name",
     *   key=null,
     *   requirements="",
     *   default=null,
     *   description="The company user last name",
     *   strict=true,
     *   map=false,
     *   nullable=false
     * )
     * @OA\Response(response=201, description="Resource was created and associated to the current customer")
     * @OA\Response(response=400, description="Ressources are not valid.")
     * @OA\Response(response=401, description="Invalid JWT token.")
     * @OA\Response(response=404, description="Resource is not found")
     * @OA\Response(response=415, description="Invalid format. The datas should be sent by JSON")
     * 
     * @OA\Tag(name="User")
     * 
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function create(User $user)
    {
        if (!$user) {
            throw new ResourceValidationException(
                sprintf('Ressource not found')
            );
        }

        $this->manager->validate($user, $this->getUser());

        return $user;
    }

    /**
     * @Rest\Put(
     *     path = "/api/users/{id}",
     *     name = "user_update",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\RequestParam(
     *   name="first_name",
     *   key=null,
     *   requirements="",
     *   default=null,
     *   description="The company user first name",
     *   strict=true,
     *   map=false,
     *   nullable=false
     * )
     * @Rest\RequestParam(
     *   name="last_name",
     *   key=null,
     *   requirements="",
     *   default=null,
     *   description="The company user last name",
     *   strict=true,
     *   map=false,
     *   nullable=false
     * )
     * @Rest\View(StatusCode = 200)
     * @OA\Response(response=201, description="Returns when modifications were apply to the user")
     * @OA\Response(response=400, description="Ressources are not valid.")
     * @OA\Response(response=401, description="Invalid JWT token.")
     * @OA\Response(response=404, description="Resource is not found")
     * @OA\Response(response=403, description="Access denied - the ressource is not belonging to your company")
     * @OA\Response(response=415, description="Invalid format. The datas should be sent by JSON")
     * 
     * @OA\Tag(name="User")
     * 
     * @ParamConverter("newUser", converter="fos_rest.request_body")
     */
    public function updateAction(User $user, User $newUser)
    {
        if ($user->getCustomer() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $this->manager->update($user, $newUser);

        return $user;
    }

    /**
     * @Rest\Delete(
     *     path = "/api/users/{id}",
     *     name = "user_delete",
     *     requirements = {"id"="\d+"}
     * )
     * 
     * @OA\Response(response=204, description="Resource was deleted")
     * @OA\Response(response=404, description="Resource is not found")
     * @OA\Response(response=401, description="Invalid JWT token.")
     * @OA\Response(response=403, description="Access denied - the ressource is not belonging to your company")
     * 
     * @OA\Tag(name="User")
     * 
     * @Rest\View(StatusCode = 204)
     */
    public function delete(User $user)
    {
        if ($user->getCustomer() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        return;
    }
}
