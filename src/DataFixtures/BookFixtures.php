<?php

namespace App\DataFixtures;

use App\Entity\Book;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $category1 = $this->getReference(BookCategoryFixtures::CATEGORY_1);
        $category2 = $this->getReference(BookCategoryFixtures::CATEGORY_2);

        $book = (new Book())
            ->setTitle('Book 1')
            ->setPublishDate(new DateTime('2022-04-01'))
            ->setMeap(false)
            ->setAuthors(['Testov Test'])
            ->setSlug('book-1')
            ->setCategories(new ArrayCollection([$category1, $category2]))
            ->setImage('https://www.anilibria.tv/storage/releases/posters/8700/eROIodtYPzLgNiJU.jpg');

        $manager->persist($book);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BookCategoryFixtures::class,
        ];
    }
}
