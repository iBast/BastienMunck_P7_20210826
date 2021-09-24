<?php

namespace App\Manager;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\ResourceValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    protected $manager;
    protected $validator;

    public function __construct(EntityManagerInterface $manager, ValidatorInterface $validator)
    {
        $this->manager = $manager;
        $this->validator = $validator;
    }

    public function validate(User $user, Customer $customer)
    {
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setCustomer($customer);

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new BadRequestHttpException($errorsString, null, 400);
        }

        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function update(User $user, User $newUser)
    {
        if ($newUser->getFirstName()) {
            $user->setFirstName($newUser->getFirstName());
        }
        if ($newUser->getLastName()) {
            $user->setLastName($newUser->getLastName());
        }

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new BadRequestHttpException($errorsString, null, 400);
        }

        $this->manager->persist($user);
        $this->manager->flush();
    }
}
