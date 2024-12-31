<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$phone = isset($_POST["mobile"]) ? $_POST["mobile"] : "";
if ($phone == "") {
    $phone = isset($_POST["Pmobile"]) ? $_POST["Pmobile"] : "";
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'letscomparemail@gmail.com';
    $mail->Password   = 'czjdlslexxhxwqga';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('letscomparemail@gmail.com');
    $mail->addAddress('letscomparemail@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'Lead From Google Ads';
    $mail->Body    = "Mobile: $phone";

    if ($mail->send()) {
        // Prepare data for Pabbly webhook
        $webhook_url = "https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZmMDYzNzA0M2M1MjY5NTUzMzUxMzAi_pc";
        $data = [
            'unique_id' => uniqid('webhook_', true),
            'mobile' => $phone
        ];

        // Send data to Pabbly
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webhook_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Log webhook response for debugging
        // file_put_contents('mailsend_webhook_log.txt', "Response: $response\nData: " . json_encode($data) . "\n", FILE_APPEND);

        echo 2;    
    } else {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}

?>
