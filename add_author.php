<?php
    // Add author to the book
require_once('./connection.php');
 
if (isset($_POST['book_id']) && isset($_POST['author_id']) && $_POST['action'] == 'add_author') {
    $id = $_POST['book_id'];
}
 
if (isset($_POST['action']) && $_POST['action'] == 'add_author') {

    $stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)');
    $stmt->execute([
        'book_id' => $id,
        'author_id' => $_POST['author_id']
    ]);
    header("Location: ./edit.php?id={$id}");
}else{
    header("Location: ./index.php");
}
