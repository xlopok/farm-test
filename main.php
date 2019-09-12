<?php

abstract class Animal
{
    protected $id;

    public function __construct()
    {
        $this->id = mt_rand(0, 999);
    }

    public function getId()
    {
        return $this->id;
    }
}

interface giveMilk {
    public function giveMilk();
    public function getMilk(): int;
}

interface giveEggs {
    public function giveEggs();
    public function getEggs(): int;
}


class Cow extends Animal implements giveMilk
{
    private $milk = 0;

    public function giveMilk()
    {
        $this->milk = rand(8, 12);
    }

    public function getMilk(): int
    {
        return $this->milk;
    }
}

class Chicken extends Animal implements giveEggs
{
    private $eggs = 0;

    public function giveEggs()
    {
        $this->eggs = rand(0, 1);
    }

    public function getEggs(): int
    {
        return $this->eggs;
    }
}

class Farm
{
    private $name = '';
    private $animals = [];
    private $totalMilk = 0;
    private $totalEggs = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getFarmName(): string
    {
        return $this->name;
    }

    public function addAnimal(Animal $animal)
    {
        $this->animals[] = $animal;
    }

    public function getAnimals(): ?array
    {
        return $this->animals;
    }

    public function getTotalMilk(): int
    {
        return $this->totalMilk;
    }

    public function getTotalEggs(): int
    {
        return $this->totalEggs;
    }

    public function collectGoods()
    {
        foreach ($this->animals as $animal) {
            if($animal instanceof giveMilk) {
                $animal->giveMilk();
                $this->totalMilk  += $animal->getMilk();
            }

            if($animal instanceof giveEggs) {
                $animal->giveEggs();
                $this->totalEggs += $animal->getEggs();
            }
        }
    }
}

$farm = new Farm('Ферма Дядушки Бена');
define("Cows", 10);
define("Chickens", 20);

for ($i = 0; $i < Cows; $i++) {
    $farm->addAnimal(new Cow());
}

for ($i = 0; $i < Chickens; $i++) {
    $farm->addAnimal(new Chicken());
}
$farm->collectGoods();

echo "На ферме \"" . $farm->getFarmName() . "\" было собрано: " . $farm->getTotalMilk() . ' л. молока и ' . $farm->getTotalEggs() . ' шт. яиц.'.'<br>';

