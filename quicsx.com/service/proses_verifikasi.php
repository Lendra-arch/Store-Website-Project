<?php
// Sertakan file PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Jika menggunakan Composer
// require 'path/to/PHPMailer/src/PHPMailer.php'; // Jika diunduh manual
// require 'path/to/PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    // Konfigurasi SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.elasticemail.com'; // Host SMTP Elastic Email
    $mail->SMTPAuth = true;
    $mail->Username = 'quicsx@gmail.com'; // Email Anda
    $mail->Password = '6972158409883981FA8F2356282C961C0650'; // API Key Elastic Email
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Gunakan 'PHPMailer::ENCRYPTION_SMTPS' untuk port 465
    $mail->Port = 2525; // Port yang digunakan (2525, 587, atau 465)

    // Pengaturan email pengirim dan penerima
    $mail->setFrom('quicsx.verif@gmail.com', 'Aktivasi Akun');
    $mail->addAddress('lendrjhh@gmail.com', 'Lendra'); 

    // Konten email
    $mail->isHTML(true);
    $mail->Subject = 'Judul Email';
    $mail->Body    = 'Isi email dalam format HTML.';
    $mail->AltBody = 'Isi email dalam format plain text.';

    // Kirim email
    $mail->send();
    echo 'Pesan berhasil dikirim';
} catch (Exception $e) {
    echo "Pesan gagal dikirim. Mailer Error: {$mail->ErrorInfo}";
}
