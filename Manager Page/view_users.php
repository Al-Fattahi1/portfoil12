<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

require '../db.php';

$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'user'");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض المستخدمين</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: right; /* محاذاة النص إلى اليمين */
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: blue;
        }
        a {
            display: block;
            text-align: center;
            margin: 20px 0;
            background-color: #007BFF;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: blue;
        }
    </style>
</head>
<body>
    <h1>عرض المستخدمين</h1>
    <table>
        <tr>
            <th>اسم المستخدم</th>
            <th>البريد الإلكتروني</th>
            <th>تاريخ التسجيل</th>
            <th>إجراءات</th> <!-- عمود الإجراءات -->
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['created_at']) ?></td>
            <td>
                <form action="delete_user.php" method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                    <button type="submit" onclick="return confirm('هل تريد بالتأكيد حذف هذا المستخدم؟');">حذف</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="dashboard.php">عودة إلى لوحة التحكم</a>
</body>
</html>