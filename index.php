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
<form action="apis/send-verification-mail.php" id="verification-form" method="POST">
    <label for="email">Enter Email ID: </label>
    <input type="email" name="email" id="email" placeholder="Enter Email ID" required/>
    <br><br>
    <div id="otp-div" style="display: none">
        <label for="otp">Enter OTP: </label>
        <input type="number" name="otp" id="otp" placeholder="Enter otp"/>
        <br><br>
    </div>
    <button type="submit" name="submit">Submit</button>
</form>
</body>

<script>
    let headers = {
        headers : {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    };
    fetch("apis/check-session.php", headers)
        .then(response => response.json())
        .then(body => {
            if(body.success) {
                document.getElementById('otp-div').style.display = 'block';
                document.getElementById('verification-form').action = 'apis/verify-otp.php';
            }
        });



</script>

</html>
