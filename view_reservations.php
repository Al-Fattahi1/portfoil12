<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// استرجاع الحجوزات الخاصة بالمستخدم
$stmt = $pdo->prepare("SELECT * FROM reservations WHERE email = (SELECT email FROM users WHERE id = ?)");
$stmt->execute([$_SESSION['user_id']]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>عرض الحجوزات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .total {
            font-weight: bold;
            color: #d9534f;
            font-size: 1.2em;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 20px 0;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }
        .btn:hover {
            background-color: blue;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>عرض الحجوزات</h1>

        <?php if (count($reservations) > 0): ?>
            <table>
                <tr>
                    <th>اسم المسافر</th>
                    <th>البريد الإلكتروني</th>
                    <th>رقم الهاتف</th>
                    <th>نوع الباص</th>
                    <th>الوجهة</th>
                    <th>التاريخ</th>
                    <th>عدد الركاب</th>
                    <th>إجمالي السعر</th>
                </tr>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['name']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['email']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['phone']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['bus_type']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['destination']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['passengers']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['total_price']); ?> ريال</td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>لا توجد لديك أي حجوزات حالياً.</p>
        <?php endif; ?>

        <a href="index.php" class="btn">العودة إلى الصفحة الرئيسية</a>
    </div>

    <div class="footer">
        <p>شكراً لك على استخدام نظامنا!</p>
    </div>

</body>
</html>