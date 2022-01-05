<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $subject = new Subject;
            $subject->setSubjectID("WebG301");
            $subject ->setName("Research project");
            $subject->setSchedule(\DateTime::createFromFormat('Y-m-d','2021-1-22'));
            $subject -> setMaterial("material.jpg");
            $manager -> persist($subject);
        }
        $manager->flush();
    }
}
