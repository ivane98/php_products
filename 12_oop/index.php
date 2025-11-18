<?php

// What is class and instance

class Person {
    public $name;
    public $surname;
    private $age;
    public static $counter;

    public function __construct($name, $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
        self::$counter++;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getAge() {
        return $this->age;
    }

    public static function getCounter(){
        return self::$counter;
    }
}

class Student extends Person {
    public $studentId;

    public function __construct($name, $surname, $studentId)
    {
        $this->studentId = $studentId;
        parent::__construct($name, $surname);
    }
}

// Create Person class in Person.php

$p = new Person('brad', 'traversy');
$p->setAge(30);
echo Person::getCounter();

$s = new Student('name', 'surname', 12);

echo Student::getCounter();

// Create instance of Person

// Using setter and getter