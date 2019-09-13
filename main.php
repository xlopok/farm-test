<?php

abstract class Animal
{
    protected $id;

    public function __construct()
    {
        $this->id = static::class . ':' . mt_rand(0, 999);
    }

    public function getId()
    {
        return $this->id;
    }
}

interface giveMilk {
    public function giveMilk();
}

interface giveEggs {
    public function giveEggs();
}

interface Collect {
    public function collectFromAnimal();
}


class Cow extends Animal implements giveMilk, Collect
{
    private $milk = 0;

    public function giveMilk()
    {
        $this->milk = rand(8, 12);
    }

    public function collectFromAnimal()
    {
        $this->giveMilk();
        return self::class . ':' . $this->milk;
    }
}

class Chicken extends Animal implements giveEggs, Collect
{
    private $eggs = 0;

    public function giveEggs()
    {
        $this->eggs = rand(0, 1);
    }

    public function collectFromAnimal()
    {
        $this->giveEggs();
        return self::class . ':' . $this->eggs;
    }
}

class Storage
{
    private $totalMilk = 0;
    private $totalEggs = 0;

    public function addGoods($storageItem)
    {
        $explodedStorageItem = explode(':', $storageItem);

        if($explodedStorageItem[0] === 'Cow') {
           $this->totalMilk += $explodedStorageItem[1];
        }
        if($explodedStorageItem[0] === 'Chicken') {
            $this->totalEggs += $explodedStorageItem[1];
        }
    }

    public function howMuchMilk(): int
    {
        return $this->totalMilk;
    }

    public function howMuchEggs(): int
    {
        return $this->totalEggs;
    }
}

class Farm
{
    private $name = '';
    private $animals = [];
    private $storage;

    public function __construct(string $name, Storage $storage)
    {
        $this->name = $name;
        $this->storage = $storage;
    }

    public function getFarmName(): string
    {
        return $this->name;
    }

    public function addAnimal(Animal $animal)
    {
        $this->animals[] = $animal;
    }

    public function getTotalMilk(): int
    {
        return $this->storage->howMuchMilk();
    }

    public function getTotalEggs(): int
    {
        return $this->storage->howMuchEggs();
    }


    public function collectGoods()
    {
        foreach ($this->animals as $animal) {
           $this->storage->addGoods($animal->collectFromAnimal());
        }
    }
}

$farm = new Farm('Ферма Дядушки Боба', new Storage());
define("COWS", 10);
define("CHICKENS", 20);

for ($i = 0; $i < COWS; $i++) {
    $farm->addAnimal(new Cow());
}

for ($i = 0; $i < CHICKENS; $i++) {
    $farm->addAnimal(new Chicken());
}

$farm->collectGoods();

echo "На ферме \"" . $farm->getFarmName() . "\" было собрано: " . $farm->getTotalMilk() . ' л. молока и ' . $farm->getTotalEggs() . ' шт. яиц.'.'<br>';

