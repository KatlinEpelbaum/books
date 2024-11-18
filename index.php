<?php
require_once('./connection.php');

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchQuery) {
    $stmt = $pdo->prepare('SELECT * FROM books WHERE title LIKE :search AND is_deleted = 0');
    $stmt->execute(['search' => '%' . $searchQuery . '%']);
} else {
    $stmt = $pdo->query('SELECT * FROM books WHERE is_deleted = 0');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
</head>
<body>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="GET">
        <input type="text" name="search" placeholder="Search for books..." value="<?= htmlspecialchars($searchQuery); ?>">
        <button type="submit">Search</button>
    </form>
    <ul>
        <?php while ($book = $stmt->fetch()) { ?>
            <li>
                <a href='./book.php?id=<?= $book['id']; ?>'>
                    <?= htmlspecialchars($book['title']); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</body>
</html>
