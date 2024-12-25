<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // تأكد من أن هذا السطر موجود

$mail = new PHPMailer(true); // إنشاء مثيل من PHPMailer

try {
    // إعدادات الخادم
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // استبدل بهذا خادم SMTP الخاص بك
    $mail->SMTPAuth = true;
    $mail->Username = 'mhnda9204@gmail.com'; // استبدل بهذه بيانات اعتمادك
    $mail->Password = 'M772757848Mm'; // استبدل بهذه بيانات اعتمادك
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // المستلم
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('recipient@example.com', 'Recipient Name'); // إضافة مستلم

    // محتوى البريد
    $mail->isHTML(true);
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'تم إرسال البريد بنجاح';
} catch (Exception $e) {
    echo "لم يتم إرسال البريد. البريد خطأ: {$mail->ErrorInfo}";
}
?>