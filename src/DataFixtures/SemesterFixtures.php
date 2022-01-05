<?php

namespace App\DataFixtures;

use App\Entity\Semester;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SemesterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $semester = new Semester;
            $semester-> setName("Spring");
            $semester -> setTimeStart(\DateTime::createFromFormat('Y-m-d','2021-1-22'));
            $semester -> setTimeEnd(\DateTime::createFromFormat('Y-m-d','2021-3-1'));
            $semester-> setTuition(999.9);
            $manager -> persist($semester);
            }
        $manager->flush();
    }
}
