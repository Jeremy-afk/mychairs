<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Chair;

class AppFixtures extends Fixture
{

    private static function chairsGenerator()
    {
        yield ["Tabouret Légendaire à deux pieds", "Tabouret", "Légendaire", 2, "Tabouret du légendaire Maître Chiffon. La légende raconte qu'il est mort lorsque le 3e pied à casser"];
        yield ["Trône du paysan", "Trône", "Classique", 1, "Un thrône accessible à tous et que tous utilisent"];

    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::chairsGenerator() as [$name, $type, $rarity, $nbLegs, $description])
        {
            $chair = new Chair();
            $chair -> setName($name);
            $chair -> setType($type);
            $chair -> setRarity($rarity);
            $chair -> setNbLegs($nbLegs);
            $chair -> setDescription($description);


            $manager -> persist($chair);
        }
        $manager->flush();
    }
}
