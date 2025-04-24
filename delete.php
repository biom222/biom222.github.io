<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $conn = new mysqli('localhost', 'root', '', 'itservices');
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: admin.php");
    exit;
} else {
    header("Location: admin.php");
    exit;
}
