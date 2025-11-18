<?php

// Function which prints "Hello I am Zura"

// Function with argument

// Create sum of two functions

// Create function to sum all numbers using ...$nums

// function sum(...$nums) {
//     $sum = 0;
//     foreach($nums as $n) {
//         $sum += $n;
//     }

//     return $sum;
// }

// var_dump(sum(1, 2, 3));

// Arrow functions


function sum(...$num) {
    return array_reduce($num, fn($carry, $n) => $carry + $n);
}

echo sum(1, 2, 3);
