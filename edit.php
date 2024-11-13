<?php

require_once('./connection.php');

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

// Save the updated book details
if (isset($_POST['action']) && $_POST['action'] == 'Save') {
    $stmt = $pdo->prepare('UPDATE books SET title = :title, price = :price WHERE id = :id');
    $stmt->execute([
        'id' => $id,
        'title' => $_POST['title'],
        'price' => $_POST['price']
    ]);
    header("Location: ./edit.php?id={$id}");
    exit;
}

// Fetch the book details
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

// Fetch the authors for the current book
$stmt = $pdo->prepare('SELECT a.id, a.first_name, a.last_name FROM book_authors ba 
                        LEFT JOIN authors a ON ba.author_id = a.id WHERE ba.book_id = :id');
$stmt->execute(['id' => $id]);

// Remove an author from the book
if (isset($_POST['action']) && $_POST['action'] == 'remove_author') {
    $stmt = $pdo->prepare('DELETE FROM book_authors WHERE book_id = :book_id AND author_id = :author_id');
    $stmt->execute(['book_id' => $id, 'author_id' => $_POST['author_id']]);
    header("Location: ./edit.php?id={$id}");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>
    <h1>Edit Book</h1>
    
    <form action="./edit.php?id=<?= $id; ?>" method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?= $book['title']; ?>" id="title" required>
        <br><br>
        
        <label for="price">Price:</label>
        <input type="text" name="price" value="<?= $book['price']; ?>" id="price" required>
        <br><br>

        <input type="submit" name="action" value="Save">
    </form>

    <h3>Authors:</h3>
    <ul>
        <?php while ($author = $stmt->fetch()) { ?>
            <li>
                <?= $author['first_name']; ?> <?= $author['last_name']; ?>
                <form action="./edit.php?id=<?= $id; ?>" method="post" style="display:inline;">
                    <button type="submit" name="action" value="remove_author" style="cursor:pointer; background:none; border:none; padding:0; color: red;">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30" style="vertical-align: middle; margin-left: 8px;">
                            <path d="M 14.984375 2.4863281 A 1.0001 1.0001 0 0 0 14 3.5 L 14 4 L 8.5 4 A 1.0001 1.0001 0 0 0 7.4863281 5 L 6 5 A 1.0001 1.0001 0 1 0 6 7 L 24 7 A 1.0001 1.0001 0 1 0 24 5 L 22.513672 5 A 1.0001 1.0001 0 0 0 21.5 4 L 16 4 L 16 3.5 A 1.0001 1.0001 0 0 0 14.984375 2.4863281 z M 6 9 L 7.7929688 24.234375 C 7.9109687 25.241375 8.7633438 26 9.7773438 26 L 20.222656 26 C 21.236656 26 22.088031 25.241375 22.207031 24.234375 L 24 9 L 6 9 z"></path>
                        </svg>
                    </button>
                    <input type="hidden" name="author_id" value="<?= $author['id']; ?>">
                </form>
            </li>
        <?php } ?>
    </ul>

</body>
</html>
