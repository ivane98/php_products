<?php

require_once 'database.php';
require_once 'functions.php';


$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
}

$statement = $pdo->prepare('select * from products where id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);



$errors = [];

$title = $product['title'];
$price = $product['price'];
$description = $product['description'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if (!$title) {
        $errors[] = 'Please provide the title';
    }

    if (!$price) {
        $errors[] = 'Please provide the price';
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {

        $image = $_FILES['image'] ?? null;

        $imagePath = $product['image'];

        if ($image && $image['tmp_name']) {
            if ($product['image']) {
                unlink($product['image']);
            }
        }


        if ($image && $image['tmp_name']) {

            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];

            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'], $imagePath);
        }


        $statement = $pdo->prepare("UPDATE products SET title = :title, image = :image, description = :description, price = :price WHERE id = :id");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);
        $statement->execute();


        header('Location: index.php');
    }
}

?>

<?php include_once 'views/partials/header.php' ?>
<h1>Update Product <?php echo $product['title'] ?></h1>

<?php include_once 'views/products/form.php' ?>
</body>

</html>