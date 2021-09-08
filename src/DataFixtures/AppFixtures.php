<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $admin = new Customer;
        $admin->setCompany('BM LTD')
            ->setEmail('bastien.munck@me.com')
            ->setPassword($this->hasher->hashPassword($admin, 'azerty'))
            ->setCreatedAt(new DateTimeImmutable())
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        for ($c = 0; $c < 8; $c++) {
            $customer = new Customer;
            $customer->setEmail($faker->companyEmail())
                ->setCompany($faker->company())
                ->setPassword($this->hasher->hashPassword($customer, 'azerty'))
                ->setCreatedAt(new DateTimeImmutable())
                ->setRoles(['ROLE_USER']);

            for ($u = 0; $u < 10; $u++) {
                $user = new User;
                $user->setCreatedAt(new DateTimeImmutable())
                    ->setCustomer($customer)
                    ->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName());
                $manager->persist($user);
            }
            $manager->persist($customer);
        }

        for ($p = 0; $p < 15; $p++) {
            $product = new Product;
            $product->setName('Bilemo Phone v' . $p)
                ->setDescription($faker->text())
                ->setPrice($faker->biasedNumberBetween(15000, 99000))
                ->setReleasedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
