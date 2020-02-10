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
            [
                'name' => 'P8',
                'weight' => '250',
                'height' => '100',
                'width' => '100',
                'depth' => '12',
            ],
            [
                'name' => 'SE8',
                'weight' => '50',
                'height' => '60',
                'width' => '12',
                'depth' => '123',
            ],
            [
                'name' => 'iphone45',
                'weight' => '6',
                'height' => '2',
                'width' => '1',
                'depth' => '1',
            ],
            [
                'name' => '3310',
                'weight' => '6000',
                'height' => '120',
                'width' => '210',
                'depth' => '45',
            ],
        ];

        $specifications = [
            [
                'screen_diagonal' => 5,
                'screen_resolution' => '1235x54654',
                'type_of_screen' => 'oled',
                'processor' => 'i7 intel',
                'ram' => '8',
                'internal_memory' => '128',
            ],
            [
                'screen_diagonal' => '30',
                'screen_resolution' => '16546x545',
                'type_of_screen' => 'lcd',
                'processor' => 'i7 intel',
                'ram' => '1',
                'internal_memory' => '458',
            ],
            [
                'screen_diagonal' => '12',
                'screen_resolution' => '1080x720',
                'type_of_screen' => 'oled',
                'processor' => 'i7 intel',
                'ram' => '3',
                'internal_memory' => '56',
            ],
            [
                'screen_diagonal' => 7,
                'screen_resolution' => '1235x122',
                'type_of_screen' => 'amoled',
                'processor' => 'i7 intel',
                'ram' => 15,
                'internal_memory' => 2,
            ]
        ];

        $clients = [
            [
                'email' => 'darty@darty.com',
                'password' => 'testpass',
                'firm' => 'darty',
            ],
            [
                'email' => 'fnac@fnac.com',
                'password' => 'testpass',
                'firm' => 'fnac',
            ],
            [
                'email' => 'boulanger@boulanger.com',
                'password' => 'testpass',
                'firm' => 'boulanger',
            ]
        ];
        
        foreach ($suppliers as $value){
            $supplier = new Supplier();
            $supplier->setName($value['name']);
            $supplier->setCountry($value['country']);

            $manager->persist($supplier);
        }
        $manager->flush();
        $allSupplier = $manager->getRepository(Supplier::class)->findAll();
        $nbSupp = count($allSupplier);
        foreach ($specifications as $value){
            $specification = new Specification();
            $specification->setScreenDiagonal($value['screen_diagonal']);
            $specification->setScreenResolution($value['screen_resolution']);
            $specification->setTypeOfScreen($value['type_of_screen']);
            $specification->setProcessor($value['processor']);
            $specification->setRam($value['ram']);
            $specification->setInternalMemory($value['internal_memory']);

            $manager->persist($specification);
        }
        $manager->flush();
        $allSpec = $manager->getRepository(Specification::class)->findAll();
        $nbSpec = count($allSpec);

        foreach ($phones as $value){
            $phone = new Phone();
            $phone->setName($value['name']);
            $phone->setWeight($value['weight']);
            $phone->setHeight($value['height']);
            $phone->setWidth($value['weight']);
            $phone->setDepth($value['depth']);
            $phone->setSupplier($allSupplier[rand(0,$nbSupp-1)]);
            $phone->setSpecification($allSpec[rand(0, $nbSpec-1)]);

            $manager->persist($phone);
        }

        foreach ($clients as $value){
            $client = new Client();
            $client->setEmail($value['email']);
            $client->setPassword(password_hash($value['password'], PASSWORD_BCRYPT));
            $client->setFirm($value['firm']);

            $manager->persist($client);
        }
        $manager->flush();
        $allClient = $manager->getRepository(Client::class)->findAll();
        $nbClient = count($allClient);

        for($i=0; $i < 20; $i++){
                $user = new EndUser();
                $user->setEmail($faker->email);
                $user->setFistName($faker->firstName);
                $user->setLastName($faker->lastName);
                $user->setClient($allClient[rand(0,$nbClient-1)]);
                $manager->persist($user);
        }
        $manager->flush();
    }
}
