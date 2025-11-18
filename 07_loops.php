<?php

// while

// Loop with $counter

// do - while

// for

// foreach
$fruits = ['banana', 'apple'];

// foreach($fruits as $i => $fruit) {
//     echo $i . $fruit;
// }

// Iterate Over associative array.

$person = [
    'name' => 'ivane',
    'hobbies' => ['hello', 'world']
];

foreach($person as $key => $value){
    if(is_array($value)) {
        echo $key.' '.implode(',', $value);
    }else {
        echo $key.' '.$value;
    }
}