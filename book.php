<?php

require_once('./connection.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE ba.book_id = :id');
$stmt->execute(['id' => $id]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title']; ?></title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f9fc; 
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #ffffff; 
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
        }
        .image-container {
            flex: 0 0 200px;
            margin-right: 20px;
        }
        img {
            max-width: 100%;
            border-radius: 8px;
            border: 2px solid #e1bee7; 
        }
        .info-container {
            flex: 1;
        }
        h1 {
            color: #5e35b1; 
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        h3 {
            color: #6a1b9a; 
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .authors {
            font-style: italic;
            color: #4a4a4a;
            margin: 5px 0 15px 0;
        }
        p {
            line-height: 1.6;
            margin: 15px 0;
            padding: 10px;
            background-color: #f3e5f5; 
            border-radius: 5px;
        }
        .price {
            font-size: 1.5em;
            color: #ff4081; 
            margin: 10px 0;
        }
        .edit-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #64b5f6; 
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
        }
        .edit-link:hover {
            background-color: #42a5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="<?= $book['cover_path']; ?>" alt="">
        </div>
        <div class="info-container">
            <h1><?= $book['title']; ?></h1>
            <div class="authors">
                <?php
                $authors = [];
                while ($author = $stmt->fetch()) {
                    $authors[] = $author['first_name'] . ' ' . $author['last_name'];
                }
                echo implode(', ', $authors);
                ?>
            </div>
            <h3>Release Date:</h3>
            <p><?= $book['release_date']; ?></p>
            <h3>Language:</h3>
            <p><?= $book['language']; ?></p>
            <h3>Summary:</h3>
            <p><?= $book['summary']; ?></p>
            <h3 class="price">Price: $<?= round($book['price'], 2); ?></h3>
            <h3 class="stock">Stock: <?= $book['stock_saldo']; ?></h3>
            <h3 class="pages">Pages: <?= $book['pages']; ?></h3>
            <h3 class="type">Type: <?= $book['type']; ?></h3>
            <a class="edit-link" href="./edit.php?id=<?= $id; ?>">Edit Book Details</a>
        </div>
    </div>
    <form action="./delete.php" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="submit" name="action" value="Delete">
    </form>
</body>
</html>
