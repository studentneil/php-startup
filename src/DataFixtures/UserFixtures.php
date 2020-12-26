<?php
declare(strict_types=1);
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    const REFERENCE = 'ref';
    private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder;
	}

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('neil@gmail.com');
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $user->setPassword($this->encoder->encodePassword(
            $user,
             'password'
        ));

        $manager->persist($user);

        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }
}
