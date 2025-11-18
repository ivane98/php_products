<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$title = '';
$price = '';
$description = '';

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

function randomString($n)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $str = '';
  for ($i = 0; $i < $n; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $str .= $characters[$index];
  }

  return $str;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <link rel="stylesheet" href="app.css">
</head>

<body>
  <h1>Create new Product</h1>

  <?php if ($errors): ?>
    <?php foreach ($errors as $error): ?>
      <div class="alert alert-danger">
        <?php echo $error; ?>
      </div>
    <?php endforeach ?>
  <?php endif ?>

  <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Image</label>
      <input type="file" name="image">
    </div>
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea type="text" name="description" class="form-control"><?php echo $description; ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Price</label>
      <input type="number" name='price' step=".01" class="form-control" value="<?php echo $price; ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>

</html>