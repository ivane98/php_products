<?php 
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


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

    <form action="post">
  <div class="mb-3">
    <label  class="form-label">Image</label>
    <input type="file" name="image" >
  </div>
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea type="text" name="description" class="form-control"></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number" name='price' step=".01" class="form-control">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </body>
</html>