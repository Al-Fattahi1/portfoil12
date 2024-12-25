<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

require '../db.php';

// حذف باص
if (isset($_GET['delete'])) {
    $bus_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM buses WHERE id = ?");
    $stmt->execute([$bus_id]);
}

// استرجاع بيانات الباصات
$stmt = $pdo->query("SELECT * FROM buses");
$buses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الباصات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
            color: white;
            border: none;
            border-radius: 4px;
        }
        .edit {
            background-color: #007BFF;
        }
        .delete {
            background-color: #FF5733;
        }
        .delete:hover, .edit:hover {
            opacity: 0.8;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            background-color: #007BFF;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: blue;
        }
    </style>
</head>
<body>
    <h1>إدارة الباصات</h1>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>رقم الباص</th>
                    <th>عدد المقاعد</th>
                    <th>الوجهة</th>
                    <th>خيارات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buses as $bus): ?>
                    <tr>
                        <td><?= htmlspecialchars($bus['bus_number']) ?></td>
                        <td><?= htmlspecialchars($bus['seats']) ?></td>
                        <td><?= htmlspecialchars($bus['route']) ?></td>
                        <td>
                            <a href="edit_bus.php?id=<?= $bus['id'] ?>" class="edit">تعديل</a>
                            <a href="?delete=<?= $bus['id'] ?>" class="delete" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الباص؟');">حذف</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_buses.php" class="back-link">إضافة باص جديد</a>
        <a href="dashboard.php" class="back-link">عودة إلى لوحة التحكم</a>
    </div>
</body>
</html>