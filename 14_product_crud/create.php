<?php

require_once 'database.php';
require_once 'functions.php';



$errors = [];

$title = '';
$price = '';
$description = '';
$product = [
  'image' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $date = date('Y:m:d H:i:s');

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

    $imagePath = '';
    if ($image && $image['tmp_name']) {

      $imagePath = 'images/' . randomString(8) . '/' . $image['name'];

      mkdir(dirname($imagePath));

      move_uploaded_file($image['tmp_name'], $imagePath);
    }


    $statement = $pdo->prepare("insert into products (title, image, description, price, created_at) values (:title, :image, :description, :price, :date)");

    $statement->bindValue(':title', $title);
    $statement->bindValue(':image', $imagePath);

    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':date', $date);

    $statement->execute();
    header('Location: index.php');
  }
}
?>
<?php include_once 'views/partials/header.php' ?>
<h1>Create new Product</h1>

<?php include_once 'views/products/form.php' ?>
</body>

</html>