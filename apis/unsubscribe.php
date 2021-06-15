<?php
    require_once dirname( __DIR__ ) . '/classes/class-user.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comic Mailer</title>
</head>

<body>
    <?php
        if ( isset( $_GET['email']  ) ) {
            $email = $_GET['email'];
            $user = new User();

            if ( $user->unsubscribe( $email ) == 'success' ) {
                echo '<h1 style="text-align: center;">Service Unsubscribed successfully</h1>';
            } else {
                echo '<h1 style="text-align: center;">Unsubscribing failed please try again latter.</h1>';
            }

        } else {
            echo '<h1 style="text-align: center;">Missing Required Parameters</h1>';
        }
    ?>
</body>

</html>
