<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Chair;
use App\Entity\Stack;
use App\Entity\Member;

class AppFixtures extends Fixture
{

    private static function chairsGenerator()
    {
        yield ["Tabouret Légendaire à deux pieds", "Tabouret", "Légendaire", 2, "Tabouret du légendaire Maître Chiffon. La légende raconte qu'il est mort lorsque le 3e pied à casser"];
        yield ["Trône du paysan", "Trône", "Classique", 1, "Un thrône accessible à tous et que tous utilisent"];

    }

    private static function membersGenerator()
    {
        yield[1, 'Aymeric Lacroix', "Aime les chaises réglables et si possible capable de se mettre à l'orizontable"];
    }

    private static function stacksGenerator()
    {
        yield [1234, true, "Ceci est une description", "Name"];
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

        foreach (self::membersGenerator() as [$id, $name, $description])
        {
            $member = new Member();
            $member -> setId($id);
            $member -> setNom($name);
            $member -> setDescription($description);


            $manager -> persist($member);
        }

        $manager->flush();

        foreach (self::stacksGenerator() as [$id, $isPublic, $description, $name, $memberId])
        {
            $stack = new Stack();

            $stack -> setId($id);
            $stack -> setIsPublic($isPublic);
            $stack -> setDescription($description);
            $stack -> setName($name);
            $stack -> setMember($member);

            $manager -> persist($stack);
        }

        $manager->flush();
    }
}
