<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Kids;
use App\Entity\Program;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{


  /**
   * @var UserPasswordEncoderInterface
   */
  private $passwordEncoder;
  /**
   * @var SluggerInterface
   */
  private $slugger;

  public function __construct(SluggerInterface $slugger,UserPasswordEncoderInterface $passwordEncoder)
  {
    $this->passwordEncoder = $passwordEncoder;
    $this->slugger = $slugger;
  }

  public function load(ObjectManager $manager)
    {
      $faker = \Faker\Factory::create('fr_FR');

      // Créer les catégories
      $plainCategories = ['Programme Explorateurs 5-7ans', 'Programme Concepteurs 8-12ans', 'Programme Développeurs 13-15ans', 'Vacances'];
      $categories = [];
      $programs = [];

      foreach ($plainCategories as $plainCategory) {
        $category = new Category();
        $category->setName($plainCategory);
        $category->setSlug($this->slugger->slug($plainCategory)->lower());
        $manager->persist($category);
        $categories[] = $category;
      }

      $users = [];
      //Créer les utilisateurs
      for ($i = 1; $i <= 10; $i++) {
        $mail = (1 === $i) ? 'fratardlucas@gmail.com' : $faker->email;
        $roles = (1 === $i) ? ['ROLE_ADMIN'] : ['ROLE_USER'];

        $user = new User();
        $user->setMail($mail);
        $user->setPassword(
          $this->passwordEncoder->encodePassword($user, 'testtest')
        );
        $user->setRoles($roles);
        $user->setLastname($faker->lastName);
        $user->setFirstname($faker->firstName);
        $user->setPhone('0312345678');
        $manager->persist($user);
        $users[] = $user;
      }

      //Créer les Programmes
      for ($i = 1; $i <= 5; ++$i) {
        $program = new Program();
        $program->setName('Program '.$i);
        $program->setDescription($faker->text);
        $program->setRegistration($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = 'Europe/Paris'));
        $program->setStartDate($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = 'Europe/Paris'));
        $program->setEndDate($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = 'Europe/Paris'));
        $program->setCategory($categories[rand(0,2)]);
        $manager->persist($program);
        $programs[] = $program;
      }

      $kids = [];
      $p = 0;
      //Créer les enfants
      for ($i = 1; $i <= 15; $i++) {
        $kid = new Kids();
        $kid->setName($faker->firstName);
        $kid->setBirthday($faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = 'Europe/Paris'));
        $kid->setUser($users[rand(0,(count($users)-1))]);
        while ($p <= rand(1,3)){
          $kid->addProgram($programs[rand(0,(count($programs)-1))]);
          $p++;
        }
        $p = 0;
        $manager->persist($kid);
        $kids[] = $kid;
      }

        $manager->flush();
    }
}
