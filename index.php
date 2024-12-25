<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleIndex.css">
    <title>نظام حجز الباصات</title>
    
</head>
<body>
    <h1>مرحباً بك في نظام حجز الباصات</h1>
    <nav>
        <ul>
            <li><a href="book.php">احجز باص</a></li>
            <li><a href="view_reservations.php">عرض الحجوزات</a></li>
            <li><a href="contact.php">اتصل بنا</a></li>
            <?php session_start(); ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">تسجيل الخروج</a></li>
                <li>مرحباً، <?php echo htmlspecialchars($_SESSION['username']); ?></li>
            <?php else: ?>
                <li><a href="login.php">تسجيل الدخول</a></li>
                <li><a href="register.php">إنشاء حساب</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <section class="info" style="text-align: right;">
    <h2>نظام حجز الباصات</h2>
    <p>
        يوفر نظام حجز الباصات تجربة سهلة ومباشرة للمستخدمين، حيث يمكنهم التخطيط لرحلاتهم وحجز المقاعد بكل بساطة.
    </p>
    <h3>مميزات النظام:</h3>
    <ul>
        <li><strong>سهولة الاستخدام:</strong> واجهة بسيطة وسهلة التصفح.</li>
        <li><strong>خيارات متعددة:</strong> توفر رحلات متنوعة تناسب احتياجاتك.</li>
        <li><strong>إدارة الحجوزات:</strong> إمكانية تعديل أو إلغاء الحجوزات بسهولة.</li>
        <li><strong>أسعار تنافسية:</strong> عروض مناسبة لجميع المستخدمين.</li>
    </ul>
    <h3>كيفية العمل:</h3>
    <p>
        - قم بالتسجيل في النظام باستخدام بريدك الإلكتروني.
    </p>
    <p>
        - ابحث عن الرحلات المتاحة حسب وجهتك وموعد السفر.
    </p>
    <p>
        - اختر الرحلة المناسبة وأكمل عملية الحجز.
    </p>
    <p>
        - يمكنك الوصول إلى حسابك في أي وقت لإدارة حجوزاتك.
    </p>
    <h3>انضم إلينا!</h3>
    <p>
        سجل الآن واستمتع بتجربة سفر مريحة وآمنة مع نظام حجز الباصات.
    </p>
</section>

</body>
</html>


