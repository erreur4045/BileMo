<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\EndUser;
use App\Entity\Phone;
use App\Entity\Specification;
use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $suppliers = [
            [
                'name' => 'honor',
                'country' => 'chine'
            ],
            [
                'name' => 'apple',
                'country' => 'usa'
            ],
            [
                'name' => 'huawei',
                'country' => 'chine'
            ],
            [
                'name' => 'samsung',
                'country' => 'corée'
            ],
            [
                'name' => 'nokia',
                'country' => 'finlande'
            ]
        ];

        $phones = [
            'P8',
            'SE8',
            'iphone45',
            '3310',
            'dsfsdf',
            'sdfsdfsdf',
            'sdfsdfsdfsdf',
            'sdfsdfsdfsdf',
            'sdfsdfsdfdsf',
            'sdfsdfsdfsdf',
            'sdfsdfsdf',
            'sdfsdfsdfsdf'
        ];

        $clients = [
            [
                'username' => 'darty',
                'password' => 'testpass',
                'firm' => 'darty',
            ],
            [
                'username' => 'fnac',
                'password' => 'testpass',
                'firm' => 'fnac',
            ],
            [
                'username' => 'boulanger',
                'password' => 'testpass',
                'firm' => 'boulanger',
            ]
        ];

        $specifications = ['oled', 'lcd', 'cathode','amoled'];
        $networks = ['2G', '3G', '4G', '5G'];
        $processors = ['i5','i7','i9','i3'];
        $allOs = ['IOs', 'Android', 'WindowsPhone', 'Unix'];

        foreach ($suppliers as $value) {
            $supplier = new Supplier();
            $supplier->setName($value['name']);
            $supplier->setCountry($value['country']);

            $manager->persist($supplier);
        }
        $manager->flush();
        /** @var Supplier $allSupplier */
        $allSupplier = $manager->getRepository(Supplier::class)->findAll();
        $nbSupp = count($allSupplier);
        foreach ($specifications as $value) {
            $specification = new Specification();
            $specification->setScreendiagonal(rand(4, 8));
            $specification->setScreenresolution('1080x720');
            $specification->setProcessor($processors[array_rand($processors)]);
            $specification->setRam(rand(1, 12));
            $specification->setMemorycard(rand(0, 1));
            $specification->setPhotosensor(rand(1, 12));
            $specification->setFrontphotosensor(rand(1, 6));
            $specification->setNetwork($networks[array_rand($networks)]);
            $specification->setTypeofscreen($value);
            $specification->setBatterycapacity(rand(2000, 6000));
            $specification->setOperatingsystem($allOs[array_rand($allOs)]);
            $specification->setNfc(rand(0, 1));
            $specification->setDualsim(rand(0, 1));
            $specification->setInternalmemory(rand(64, 128));

            $manager->persist($specification);
        }
        $manager->flush();
        /** @var Specification $allSpec */
        $allSpec = $manager->getRepository(Specification::class)->findAll();
        $nbSpec = count($allSpec);

        foreach ($phones as $value) {
            $phone = new Phone();
            $phone->setName($value);
            $phone->setWeight(rand(50, 500));
            $phone->setHeight(rand(100, 500));
            $phone->setWidth(rand(100, 500));
            $phone->setDepth(rand(5, 30));
            $phone->setPrice(rand(100, 500));
            $phone->setSupplier($allSupplier[rand(0, $nbSupp - 1)]);
            $phone->setSpecification($allSpec[rand(0, $nbSpec - 1)]);

            $manager->persist($phone);
        }

        foreach ($clients as $value) {
            $client = new Client();
            $client->setUsername($value['username']);
            $client->setPassword(password_hash($value['password'], PASSWORD_BCRYPT));
            $client->setFirm($value['firm']);
            $manager->persist($client);
        }
        $manager->flush();
        $allClient = $manager->getRepository(Client::class)->findAll();
        $nbClient = count($allClient);

        for ($i = 0; $i < 33; $i++) {
            $user = new EndUser();
            $user->setEmail($faker->email);
            $user->setFistName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setClient($allClient[0]);
            $manager->persist($user);
        }

        for ($i = 0; $i < 33; $i++) {
                $user = new EndUser();
                $user->setEmail($faker->email);
                $user->setFistName($faker->firstName);
                $user->setLastName($faker->lastName);
                $user->setClient($allClient[1]);
                $manager->persist($user);
        }
        for ($i = 0; $i < 34; $i++) {
            $user = new EndUser();
            $user->setEmail($faker->email);
            $user->setFistName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setClient($allClient[rand(0, $nbClient - 1)]);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
