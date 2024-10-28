    <?php
    require_once('./connection.php');

    $stmt = $pdo->query('SELECT * FROM books WHERE is_deleted = 0');
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>

        <ul>
        <?php while ($book = $stmt->fetch()){   ?> 
            <li>
                <a href= './book.php?id=<?=$book['id']; ?>'>
                    <?= $book['title']; ?>
                </a>
            </li>
        </ul>
        <?php } ?>
    </body>
    </html>