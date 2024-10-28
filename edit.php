<?php

require_once('./connection.php');

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (isset($_POST['action']) && $_POST['action'] == 'Save') {
    $stmt = $pdo->prepare('UPDATE books SET title = :title, price = :price WHERE id = :id');
    $stmt->execute([
        'id' => $id,
        'title' => $_POST['title'],
        'price' => $_POST['price']
    ]);

    header("Location: ./book.php?id={$id}");
}

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<body>
    <form action="./edit.php?id=<?= $id; ?>" method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?= $book['title']; ?>" id="title" required>
        <br><br>
        
        <label for="price">Price:</label>
        <input type="text" name="price" value="<?= $book['price']; ?>" id="price" required>
        <br><br>

        <input type="submit" name="action" value="Save">
    </form>
</body>
</html>
