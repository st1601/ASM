<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $student = new Student; 
            $student->setName("Student $i");
            $student->setBirthday(\DateTime::createFromFormat('Y-m-d','2000-04-18'));
            $student->setAddress("Ha Noi");
            $student->setMobile("0912345678");
            $student->setCover("student1.jpg");
            $manager->persist($student);
        }
        $manager->flush();
    }
}
