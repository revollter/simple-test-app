<?php

namespace App\DataFixtures;

use App\Entity\Data;
use App\Entity\User;
use App\Enum\Product;
use App\Enum\Color;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DataFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws \DateMalformedStringException
     */
    public function load(ObjectManager $manager): void
    {

        $allUsers = $manager->getRepository(User::class)->findAll();

        $users = array_combine(
            array_map(fn(User $u) => $u->getId(), $allUsers),
            $allUsers
        );

        $data = [
            ['user_id'=>2,'date'=>'2025-11-01','product'=>'Pen','color'=>'Blue','amount'=>3],
            ['user_id'=>3,'date'=>'2025-11-02','product'=>'Pen','color'=>'Red','amount'=>1],
            ['user_id'=>3,'date'=>'2025-11-03','product'=>'Pen','color'=>'Red','amount'=>3],
            ['user_id'=>3,'date'=>'2025-11-04','product'=>'Pen','color'=>'Blue','amount'=>2],
            ['user_id'=>2,'date'=>'2025-11-05','product'=>'Pen','color'=>'Black','amount'=>1],
            ['user_id'=>2,'date'=>'2025-11-06','product'=>'Pen','color'=>'Black','amount'=>2],
            ['user_id'=>4,'date'=>'2025-11-07','product'=>'Pencil','color'=>null,'amount'=>5],
            ['user_id'=>4,'date'=>'2025-11-08','product'=>'Pen','color'=>'Blue','amount'=>3],
            ['user_id'=>2,'date'=>'2025-11-04','product'=>'Pen','color'=>'Black','amount'=>3],
            ['user_id'=>2,'date'=>'2025-11-05','product'=>'Pen','color'=>'Black','amount'=>1],
            ['user_id'=>3,'date'=>'2025-11-06','product'=>'Pencil','color'=>null,'amount'=>2],
            ['user_id'=>4,'date'=>'2025-11-07','product'=>'Pen','color'=>'Black','amount'=>3],
            ['user_id'=>3,'date'=>'2025-11-08','product'=>'Pencil','color'=>null,'amount'=>5],
            ['user_id'=>2,'date'=>'2025-11-02','product'=>'Pen','color'=>'Red','amount'=>6],
            ['user_id'=>3,'date'=>'2025-11-07','product'=>'Pen','color'=>'Red','amount'=>3],
            ['user_id'=>4,'date'=>'2025-11-08','product'=>'Pen','color'=>'Red','amount'=>2],
            ['user_id'=>4,'date'=>'2025-11-02','product'=>'Pencil','color'=>null,'amount'=>1],
            ['user_id'=>2,'date'=>'2025-11-04','product'=>'Pen','color'=>'Blue','amount'=>6],
            ['user_id'=>4,'date'=>'2025-11-05','product'=>'Pencil','color'=>null,'amount'=>7],
            ['user_id'=>2,'date'=>'2025-11-02','product'=>'Pen','color'=>'Blue','amount'=>8],
        ];

        foreach ($data as $item) {
            $entity = new Data();
            $entity->setAccount($users[$item['user_id']]);
            $entity->setDate(new \DateTime($item['date']));
            $entity->setProduct(Product::from($item['product']));
            $entity->setColor($item['color'] ? Color::from($item['color']) : null);
            $entity->setAmount($item['amount']);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
