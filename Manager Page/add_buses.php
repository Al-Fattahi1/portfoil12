<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

require '../db.php';

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_number = $_POST['bus_number'];
    $seats = $_POST['seats'];
    $route = $_POST['route'];

    $stmt = $pdo->prepare("INSERT INTO buses (bus_number, seats, route) VALUES (?, ?, ?)");
    if ($stmt->execute([$bus_number, $seats, $route])) {
        $message = "تم إضافة الباص بنجاح.";
    } else {
        $error = "حدث خطأ أثناء إضافة الباص.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة باص</title>
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
        form {
            width: 100%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: blue;
        }
        .message, .error {
            text-align: center;
            margin: 10px 0;
        }
        .message {
            color: green;
        }
        .error {
            color: red;
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
        
        /* استجابة تصميم الشاشات الصغيرة */
        @media (max-width: 480px) {
            form {
                padding: 15px;
            }
            button {
                padding: 8px;
            }
            input {
                padding: 8px;
            }
            .back-link {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <h1>إضافة باص</h1>
    <div class="container">
        <form action="add_buses.php" method="POST">
            <input type="text" name="bus_number" placeholder="رقم الباص" required>
            <input type="number" name="seats" placeholder="عدد المقاعد" required>
            <input type="text" name="route" placeholder="الوجهة" required>
            <button type="submit">إضافة باص</button>
        </form>
        <?php if ($message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        
        <a href="dashboard.php" class="back-link">عودة إلى لوحة التحكم</a>
    </div>
</body>
</html>