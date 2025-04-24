<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'itservices';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Параметры фильтра
$search_name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
$search_email = isset($_GET['email']) ? $conn->real_escape_string($_GET['email']) : '';

// Пагинация
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Условия для фильтра
$where = [];
if ($search_name) $where[] = "name LIKE '%$search_name%'";
if ($search_email) $where[] = "email LIKE '%$search_email%'";
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Подсчёт общего числа записей с фильтром
$count_sql = "SELECT COUNT(*) AS total FROM messages $where_sql";
$count_result = $conn->query($count_sql);
$total_messages = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_messages / $limit);

// Получение записей с фильтром и пагинацией
$sql = "SELECT * FROM messages $where_sql ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка — Фильтр</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .pagination { margin-top: 20px; text-align: center; }
        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 4px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #007BFF;
        }
        .pagination a.active {
            background-color: #007BFF;
            color: white;
            border: 1px solid #007BFF;
        }
        form.filter { margin-bottom: 20px; }
        form.filter input { padding: 5px; margin-right: 10px; }
    </style>
</head>
<body>
    <h2>Сообщения с формы</h2>

    <!-- Фильтр -->
    <form class="filter" method="GET" action="">
        <input type="text" name="name" placeholder="Имя" value="<?= htmlspecialchars($search_name) ?>">
        <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($search_email) ?>">
        <button type="submit">Фильтровать</button>
        <a href="admin.php" style="margin-left:10px;">Сбросить</a>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Сообщение</th>
            <th>Дата</th>
            <th>Действие</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <form action="delete_message.php" method="POST" onsubmit="return confirm('Удалить сообщение?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Нет сообщений</td></tr>
        <?php endif; ?>
    </table>

    <!-- Пагинация -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&name=<?= urlencode($search_name) ?>&email=<?= urlencode($search_email) ?>">&laquo; Назад</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>&name=<?= urlencode($search_name) ?>&email=<?= urlencode($search_email) ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>&name=<?= urlencode($search_name) ?>&email=<?= urlencode($search_email) ?>">Вперед &raquo;</a>
        <?php endif; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>
