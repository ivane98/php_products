<?php

$id = $_POST['id'] ?? null;

if (!$id) {
    header('Location: index.php');
}


require_once 'database.php';


$statement = $pdo->prepare('delete from products where id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

header('Location: index.php');
