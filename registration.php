<html>
<body>
<?php
    require 'stripe-php-3.10.0/init.php';
    if($_POST) {
    // Set your secret key: remember to change this to your live secret key in production
    // See your keys here https://dashboard.stripe.com/account/apikeys
    \Stripe\Stripe::setApiKey("sk_test_RZczyef489DtihXAC8HKxvll");
    
    // Get the credit card details submitted by the form
    $token = $_POST['stripeToken'];

    // Create the charge on Stripe's servers - this will charge the user's card
    try {
      $charge = \Stripe\Charge::create(array(
        "amount" => 1000, // amount in cents, again
        "currency" => "usd",
        "source" => $token,
        "description" => "Example charge"
        ));
    } catch(\Stripe\Error\Card $e) {
      // The card has been declined
    }
    }
?>

<?php
    $servername = 'localhost:3306';
    $username = 'sysadmin';
    $passwordu = 'sysadmin';
// Create connection
    $conn = new mysqli($servername, $username, $passwordu);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(! get_magic_quotes_gpc() ){
        $Username = addslashes ($_POST['name']);
        $Email = addslashes ($_POST['email']);
        $Address = addslashes ($_POST['address']);
        $City = addslashes ($_POST['city']);
        $State = addslashes ($_POST['state']);
        $ZIP = addslashes ($_POST['zip']);
        $Password = addslashes($_POST['password']);
    }
    else{
        $Username = $_POST['name'];
        $Email = $_POST['email'];
        $Address = $_POST['address'];
        $City = $_POST['city'];
        $State = $_POST['state'];
        $ZIP = $_POST['zip'];
        $Password = $_POST['password'];
    }

    echo "<script> validateForm(); </script>";

    $sql = "INSERT INTO users ".
        "(name,email,address,city,state,zip,password) ".
          "VALUES ".
        "('$Username','$Email','$Address','$City','$State','$ZIP','$Password')";
	mysqli_select_db($conn, 'utickets');
    //echo "<h2>" . $_POST['zip'] . "</h2>";
    //echo "<script>alert($_POST['zip']);</script>";
    $retval = mysqli_query( $conn, $sql );
    
    if(! $retval )
    {
        die("<script>alert('This username has been used. please try another one.');location.href='".$_SERVER["HTTP_REFERER"]."';</script>");
    }
    echo "<script>alert('Registration Completed!');location.href='login.php';</script>";
    mysqli_close($conn);

?>

<?php
	$Username = $_POST['name'];
    $Email = $_POST['email'];
    require 'PHPMailer-master/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'pyuan4095@gmail.com';                 // SMTP username
    $mail->Password = 'xianhuapeishi43C';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('pyuan4095@gmail.com', 'UTickets');
    $mail->addAddress($Email, $Username);     // Add a recipient                        

    $mail->Subject = 'Thanks for joining UTickets';
    $mail->Body    = 'Your signup is complete! Now you have access to all UTickets excellent services!';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
?>
</body>
</html>