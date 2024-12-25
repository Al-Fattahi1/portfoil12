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
    $start_location = $_POST['start_location'];
    $end_location = $_POST['end_location'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $duration = $_POST['duration'];
    $distance = $_POST['distance'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("INSERT INTO routes (start_location, end_location, departure_time, arrival_time, duration, distance, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$start_location, $end_location, $departure_time, $arrival_time, $duration, $distance, $price])) {
        $message = "تم إضافة الرحلة بنجاح.";
    } else {
        $error = "حدث خطأ أثناء إضافة الرحلة.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM routes");
$stmt->execute();
$routes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الرحلات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
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
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: right; /* محاذاة النص إلى اليمين */
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
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
        }
    </style>
</head>
<body>
    <h1>إدارة الرحلات</h1>
    <form action="manage_routes.php" method="POST">
        <input type="text" name="start_location" placeholder="مكان الانطلاق" required>
        <input type="text" name="end_location" placeholder="مكان الوصول" required>
        <input type="datetime-local" name="departure_time" required>
        <input type="datetime-local" name="arrival_time" required>
        <input type="text" name="duration" placeholder="مدة الرحلة" required>
        <input type="number" name="distance" placeholder="المسافة (كم)" required>
        <input type="number" name="price" placeholder="السعر" required>
        <button type="submit">إضافة رحلة</button>
    </form>
    <?php if ($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>