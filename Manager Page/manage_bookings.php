<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

require '../db.php';

$stmt = $pdo->prepare("SELECT bookings.*, users.username, buses.bus_number FROM bookings JOIN users ON bookings.user_id = users.id JOIN buses ON bookings.bus_id = buses.id");
$stmt->execute();
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الحجوزات</title>
</head>
<body>
    <h1>إدارة الحجوزات</h1>
    <table>
        <tr>
            <th>اسم المستخدم</th>
            <th>رقم الباص</th>
            <th>عدد المقاعد المحجوزة</th>
            <th>تاريخ الحجز</th>
            <th>حالة الحجز</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><?= htmlspecialchars($booking['username']) ?></td>
            <td><?= htmlspecialchars($booking['bus_number']) ?></td>
            <td><?= htmlspecialchars($booking['seats_booked']) ?></td>
            <td><?= htmlspecialchars($booking['booking_date']) ?></td>
            <td><?= htmlspecialchars($booking['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="dashboard.php">عودة إلى لوحة التحكم</a>
</body>
</html>