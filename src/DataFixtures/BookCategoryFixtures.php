<?php

namespace App\DataFixtures;

use App\Entity\BookCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookCategoryFixtures extends Fixture
{
    public const CATEGORY_1 = 'android';
    public const CATEGORY_2 = 'devices';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            self::CATEGORY_1 => (new BookCategory())->setTitle(ucfirst(self::CATEGORY_1))->setSlug(self::CATEGORY_1),
            self::CATEGORY_2 => (new BookCategory())->setTitle(ucfirst(self::CATEGORY_2))->setSlug(self::CATEGORY_2),
        ];

        foreach ($categories as $category) {
            $manager->persist($category);
        }

        $manager->persist((new BookCategory())->setTitle('Networking')->setSlug('networking'));
        $manager->flush();

        foreach ($categories as $code => $category) {
            $this->addReference($code, $category);
        }
    }
}
