<?php

namespace App\DataFixtures;

use App\Entity\Release;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReleaseFixtures extends Fixture implements DependentFixtureInterface
{
    const RELEASE_REFERENCE = 'release-user';

    public function load(ObjectManager $manager)
    {
        $release = new Release();
        $release->setArtist('tricky');
        $release->setCatalogNumber('12BRW340');
        $release->setTitle('christiansnads');
        $release->setBarcode(null);
        $release->setAddedDate(new \DateTime());
        $release->setFormat('12" ep');
        $release->setReleaseDate(new \DateTime('2001-10-4'));
        $release->setGenre('electronic');
        $release->setLabel('4th and broadway');
        $release->setMediaCondition('vg+');
        $release->setSleeveCondition('vg+');
        $release->setNotes('great ep from tricky with a quality remix of christiansands. First single taken from Pre millenium tension album');
        $release->setQuantity(1);
        $release->setUser($this->getReference(UserFixtures::REFERENCE));
        $manager->persist($release);
        $manager->flush();

        $this->addReference(self::RELEASE_REFERENCE, $release);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return class-string[]
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
