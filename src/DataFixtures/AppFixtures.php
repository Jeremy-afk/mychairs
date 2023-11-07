<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Chair;
use App\Entity\Stack;
use App\Entity\Member;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture
{

    private const aymeric = 1;
    private const louis = 2;
    private const jeremy = 3;

    private const aymeric_stack_1 = 100;    
    private const aymeric_stack_2 = 101;
    private const louis_stack_1 = 102;
    private const jeremy_stack_1 = 103;

    private static function membersGenerator()
    {
        yield[1, 'Aymeric Lacroix', "Aime les chaises réglables et si possible capable de se mettre à l'orizontable","aymeric@tryhard", self::aymeric];
        yield[2, 'Louis Delyon', "Ma chaise idéale est un canapé","louis@rust", self::louis];
        yield[3, 'Jeremy Le Beau Gosse', "Dans la vie je game, c'est pourquoi il me faut une chaise de gamer","jeremy@bg", self::jeremy];

    }

    private static function stacksGenerator()
    {
        yield [1234, true, "Ceci est une description", "Le stack d'Aymerix",self::aymeric,self::aymeric_stack_1];
        yield [7777, true, "Ceci est encore une description", "Le stack d'Aymerix le retour",self::aymeric,self::aymeric_stack_2];
        yield [6666, true, "Ceci est toujours une description", "Le stack de Louis",self::louis,self::louis_stack_1];
        yield [69420, true, "Ceci n'est une description, c'est un poème", "Le stack du best",self::aymeric,self::jeremy_stack_1];
    }

    private static function chairsGenerator()
    {
        yield ["Tabouret Légendaire à deux pieds", "Tabouret", "Légendaire", 2, "Tabouret du légendaire Maître Chiffon. La légende raconte qu'il est mort lorsque le 3e pied s'est cassé",self::aymeric_stack_1];
        yield ["Trône du paysan", "Trône", "Classique", 1, "Un trône accessible à tous et que tous utilisent",self::aymeric_stack_1];
        yield ["Trône du paysan", "Trône", "Classique", 1, "Un trône accessible à tous et que tous utilisent",self::aymeric_stack_2];
        yield ["Trône du paysan", "Trône", "Classique", 1, "Un trône accessible à tous et que tous utilisent",self::louis_stack_1];
        yield ["Trône du paysan", "Trône", "Classique", 1, "Un trône accessible à tous et que tous utilisent",self::jeremy_stack_1];
        yield ["La canapé Minet", "Canapé", "Epic", 4, "Confortable pour les perms, parfait pour dormir quand on a la flemme de rentrer au U6",self::louis_stack_1];
        yield ["Le fauteuil CJ", "Fauteuil", "Ancien", 6, "Parfait pour battre Aymeric à tous les jeux (sauf Mario Party)",self::jeremy_stack_1];

    }

    public function load(ObjectManager $manager): void
    {

        foreach (self::membersGenerator() as [$id, $name, $description,$useremail, $memberReference])
        {
            $member = new Member();
            if ($useremail) {
                $user = $manager->getRepository(User::class)->findOneByEmail($useremail);
                $member->setUser($user);
        }
            $member -> setId($id);
            $member -> setNom($name);
            $member -> setDescription($description);
            $manager -> persist($member);

            $manager->flush();
            $this->addReference($memberReference, $member);
        }

        

        foreach (self::stacksGenerator() as [$id, $isPublic, $description, $name, $memberReference,$stackReference])
        {
            $member = $this->getReference($memberReference);

            $stack = new Stack();

            $stack -> setId($id);
            $stack -> setIsPublic($isPublic);
            $stack -> setDescription($description);
            $stack -> setName($name);
            $stack -> setMember($member);
            $manager -> persist($stack);

            $manager->flush();
            $this->addReference($stackReference, $stack);
        }

        

        foreach (self::chairsGenerator() as [$name, $type, $rarity, $nbLegs, $description,$stackReference])
        {
            $stack = $this->getReference($stackReference);

            $chair = new Chair();
            $chair -> setName($name);
            $chair -> setType($type);
            $chair -> setRarity($rarity);
            $chair -> setNbLegs($nbLegs);
            $chair -> setDescription($description);
            $chair -> setStack($stack);

            $stack -> addChairsInStack($chair);


            $manager -> persist($chair);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
            return [
                    UserFixtures::class,
            ];
    }
}
