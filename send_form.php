<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Подключение к БД
    $conn = new mysqli('localhost', 'root', '', 'itservices'); // 👉 Укажи своё имя БД

    if ($conn->connect_error) {
        header("Location: pages/contact.html?status=db_error");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
	if (!$stmt) {
    die("Ошибка подготовки запроса: " . $conn->error);
}
$stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'constantin.rudenko2005@gmail.com';       // 👉 Твоя почта
        $mail->Password   = 'cnzb jvxc yajw iydq';                    // 👉 App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('constantin.rudenko2005@gmail.com', 'IT Services');
        $mail->addAddress('constantin.rudenko2005@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Новое сообщение с сайта';
        $mail->Body    = "Имя: " . htmlspecialchars($name) . "<br>Email: " . htmlspecialchars($email) . "<br>Сообщение:<br>" . nl2br(htmlspecialchars($message));

        $mail->send();

        header("Location: pages/contact.html?status=success");
        exit;
    } catch (Exception $e) {
        header("Location: pages/contact.html?status=mail_error");
        exit;
    }
} else {
    header("Location: pages/contact.html?status=invalid");
    exit;
}
?>
