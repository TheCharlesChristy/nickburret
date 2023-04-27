<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["email"])) {
    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $cleardb_server = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db = substr($cleardb_url["path"], 1);
    $active_group = 'default';
    $query_builder = TRUE;

    // Connect to DB
    $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

    $email = $_POST["email"];
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM accounts WHERE Email = '$email'";
    $result = mysqli_query($conn, $sql);
    $account_type = "";
    if (mysqli_num_rows($result) == 0) {
        $insert_sql = "INSERT INTO accounts (Email, type, isAuthed, songrequested) VALUES ('$email', 'Client', 0, 0)";
        mysqli_query($conn, $insert_sql);
    } else {
        $row = mysqli_fetch_assoc($result);
        $account_type = $row['type'];
    }
    // Close the connection
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'Your_email';
    $mail->Password = "Your_app_password";
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('Your_email');
    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);
    $mail->Subject = "DJ Nick Burret";

    $email_body = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body{
                    background: linear-gradient(rgba(11, 39, 92, 1), rgba(16, 17, 51, 1)), linear-gradient(to right, rgba(4, 20, 47, 0), rgba(30, 65, 150, 0), rgba(30, 65, 150, 0), rgba(4, 20, 47, 0));
                    background-image: url(Assets/HomeBg.png);
                    background-position: center;
                }
                .button {
                    position: relative;
                    left: 50%:
                    top: 50%;
                    transform: translate(-50%, -50%);
                    display: inline-block;
                    padding: 12px 24px;
                    font-size: 16px;
                    font-weight: bold;
                    text-align: center;
                    text-decoration: none;
                    color: #ffffff;
                    background-color: #007BFF;
                    border-radius: 6px;
                    transition: background-color 0.3s;
                }

                .button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <p>Hello,</p>
            <p>Thank you for your interest in DJ Nick Burret. We have received your request and will be in touch shortly.</p>
            <p>Please click the button below to visit our website:</p>
            <a href="https://domainName/DJ'.$account_type.'?user='.$_POST["email"].'" class="button" target="_blank">Visit Our Website Here</a>
            <p>Best regards,</p>
            <p>DJ Nick Burret Team</p>
        </body>
        </html>
        ';


    $mail->Body = $email_body;

    $mail->send();

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
  <script>
    window.location.replace("https://djnickburret.herokuapp.com/DJHome");
  </script>
</head>
<body>
</body>
</html>