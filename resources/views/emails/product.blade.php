<!DOCTYPE html>
<html>
<head>
    <title>Verification Code</title>
</head>
<body>
<h2>
    Hi {{$user->email}}, Welcome to our website. <br>
    Your verification code is  {{$user->verfied_code}}
</h2>
</body>
</html>

