<?php
require_once 'vendor/autoload.php';

// Function to send message using Infobip API
function sendMessage($messageText) {
    // Create HTTP_Request2 object
    $request = new HTTP_Request2();
    $request->setUrl('https://vvgljp.api.infobip.com/sms/2/text/advanced');
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setConfig(array(
        'follow_redirects' => TRUE
    ));
    $request->setHeader(array(
        'Authorization' => 'App cbd294822614c0241f87aa6f04d898d4-8ac57a5e-e46f-4eea-98b9-0adefe23c8fb',
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ));
    $request->setBody(json_encode(array(
        "messages" => array(
            array(
                "destinations" => array(array("to" => "639812517605")),
                "from" => "ServiceSMS",
                "text" => $messageText
            )
        )
    )));

    try {
        $response = $request->send();
        if ($response->getStatus() == 200) {
            return "Message sent successfully.";
        } else {
            return 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
        }
    } catch(HTTP_Request2_Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}

// Check which button was submitted and set the message accordingly
if (isset($_POST['send_message'])) {
    $messageText = "Dear Yuan De Guzman,\n\nCongratulations! We are thrilled to inform you that you have been selected for the position of System Administration at NASA. Your hard work and dedication have paid off. Welcome to the team!\n\nPlease expect further communication regarding your onboarding process shortly.\n\nBest regards,\nNASA";
    $result = sendMessage($messageText);
    echo $result;
} elseif (isset($_POST['decline_message'])) {
    $messageText = "Dear Yuan De Guzman,\n\nThank you for your interest in the System Administration position at NASA. After careful consideration, we regret to inform you that your application was not successful at this time. We genuinely appreciate the time you invested in the application process and wish you the best in your job search.\n\nDon't be disheartened; your skills and talents are valuable, and we encourage you to explore other opportunities on our platform.\n\nBest regards,\nNASA";
    $result = sendMessage($messageText);
    echo $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
</head>
<body>
    <h1>SMS NOTIFICATION</h1>
    <!-- Form with buttons to send the message -->
    <form method="post">
        <button type="submit" name="send_message">Approved</button>
        <button type="submit" name="decline_message">Declined</button>
    </form>
</body>
</html>