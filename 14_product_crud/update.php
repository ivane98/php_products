<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    <p>
        <a href="index.php" class="btn btn-secondary">Go Back To Products</a>
    </p>
    <h1>Update Product <?php echo $product['title'] ?></h1>

    <?php if ($errors): ?>
        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>

    <form action="" method="post" enctype="multipart/form-data">
        <?php if ($product['image']): ?>
            <img style="width: 120px;" src="<?php echo $product['image']; ?>" alt="">
        <?php endif ?>
        <div class="mb-3 mt-3">
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