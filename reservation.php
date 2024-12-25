<?php
session_start();
include ('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bus_type = $_POST['bus_type'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $passengers = $_POST['passengers'];

    // تحديد سعر الرحلة
    $price_per_passenger = ($destination === 'Saudi Arabia') ? ($bus_type === 'VIP' ? 100 : 50) : ($bus_type === 'VIP' ? 150 : 75);
    $total_price = $price_per_passenger * $passengers;

    // إدراج الحجز في قاعدة البيانات
    $stmt = $pdo->prepare("INSERT INTO reservations (name, email, phone, bus_type, destination, date, passengers, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $bus_type, $destination, $date, $passengers, $total_price]);

    // إعادة توجيه إلى صفحة التأكيد
    header("Location: confirmation.php");
    exit();
}
?>