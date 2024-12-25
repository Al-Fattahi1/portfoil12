<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 30px;
            direction: rtl; /* لجعل النص باللغة العربية */
        }
        h1 {
            color:#007BFF ; /* لون العنوان */
            text-align: center;
        }
        form {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF; /* لون الزر */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: blue; /* لون الزر عند التمرير */
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007BFF; /* لون الروابط */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline; /* تأثير عند التمرير على الروابط */
        }
    </style>
    <title>إنشاء حساب</title>
</head>
<body>
    <h1>إنشاء حساب جديد</h1>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="اسم المستخدم" required>
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <button type="submit">تسجيل</button>
    </form>
    <a href="login.php">لديك حساب؟ تسجيل الدخول</a>
    <a href="index.php">العودة إلى الصفحة الرئيسية</a>

    <?php
    include ('db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // تحقق مما إذا كان المستخدم موجودًا بالفعل
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "<p>البريد الإلكتروني مستخدم بالفعل!</p>";
        } else {
            // إدراج المستخدم الجديد
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $password]);
            echo "<p>تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.</p>";
        }
    }
    ?>
</body>
</html>