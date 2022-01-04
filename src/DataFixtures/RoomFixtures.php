<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RoomFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $room = new Room; 
            $room->setName("rooms $i");
            $room->setAddress("Ha Noi");
            $room->setTeacher("Do Hong Quan");
            $room->setDescription("Description for rooms $i");
            $manager->persist($room);
        }
        $manager->flush();
    }
}
