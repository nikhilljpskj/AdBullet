<?php
session_start(); // Start session to access stored mobile number

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve survey details
    $name = $_POST['name'];
    $fathersName = $_POST['fathersName'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Retrieve mobile number from session or POST (hidden field)
  $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : "";

    // Email admin with survey details
    $to = "letscomparemail@gmail.com";
    $subject = "New Survey Submission";
    $message = "Name: $name\nFather's Name: $fathersName\nEmail: $email\nAddress: $address\nMobile: $mobile"; // Include mobile number
    $headers = "From: letscomparemail@gmail.com";

    // Pabbly webhook URL
    $webhook_url = "https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZmMDYzNzA0M2M1MjY5NTUzMzUxMzAi_pc";

    // Data to send to Pabbly
    $data = [
        'unique_id' => uniqid('webhook_', true),
        'name' => $name,
        'fathersName' => $fathersName,
        'email' => $email,
        'address' => $address,
        'mobile' => $mobile // Include mobile number
    ];

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        // Send data to Pabbly webhook
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webhook_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Log webhook response for debugging
        // file_put_contents('survey_webhook_log.txt', "Response: $response\nData: " . json_encode($data) . "\n", FILE_APPEND);

        // Clear the session variable after use
        unset($_SESSION['mobile_number']);

        echo json_encode(["status" => "success", "message" => "Survey submitted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to send email"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>