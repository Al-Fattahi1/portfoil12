<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

require '../db.php';

// استرجاع عدد الباصات
$stmt = $pdo->query("SELECT COUNT(*) AS bus_count FROM buses");
$bus_count = $stmt->fetch()['bus_count'];

// استرجاع عدد الرحلات
$stmt = $pdo->query("SELECT COUNT(*) AS trip_count FROM trips");
$trip_count = $stmt->fetch()['trip_count'];

// استرجاع عدد الحجوزات
$stmt = $pdo->query("SELECT COUNT(*) AS booking_count FROM bookings");
$booking_count = $stmt->fetch()['booking_count'];

// استرجاع عدد المستخدمين المتصلين
$stmt = $pdo->query("SELECT COUNT(*) AS online_users FROM users WHERE status = 'online'");
$online_users = $stmt->fetch()['online_users'];

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم - المدير</title>
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
        .card {
            background-color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .card h2 {
            margin: 0 0 10px;
        }
        .card a {
            display: block;
            margin-top: 10px;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .card a:hover {
            background-color: blue;
        }
        @media (max-width: 480px) {
            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <h1>لوحة التحكم - المدير</h1>
    <div class="container">
        <div class="card">
            <h2>عدد الباصات المضافة</h2>
            <p><?= $bus_count ?></p>
            <a href="manage_buses.php">إدارة الباصات</a>
        </div>
        <div class="card">
            <h2>عدد الرحلات</h2>
            <p><?= $trip_count ?></p>
            <a href="manage_trips.php">إدارة الرحلات</a>
        </div>
        <div class="card">
            <h2>عدد الحجوزات</h2>
            <p><?= $booking_count ?></p>
            <a href="manage_bookings.php">إدارة الحجوزات</a>
        </div>
        <div class="card">
            <h2>عدد المستخدمين المتصلين</h2>
            <p><?= $online_users ?></p>
            <a href="manage_users.php">عرض المستخدمين المتصلين</a>
        </div>
        <div class="card">
            <h2>تسجيل الخروج</h2>
            <a href="admin_logout.php">تسجيل الخروج</a>
        </div>
    </div>
    <a href="add_trip.php">اضافة حجوزات جديدة</a>
</body>
</html>