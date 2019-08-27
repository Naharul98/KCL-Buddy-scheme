<!DOCTYPE html>
<html>
<head>
    <title>K-Number Verification Email</title>
</head>

<body>
<h2>Hi {{$user['name']}}</h2>
<br/>
Please click on the below link to verify your K-Number. <strong>If you did not expect this email then please do not click the link and delete the email</strong>
<br/>
<br/>
<a href="{{url('user_area/verify', $user->verifyUser->token)}}">Verify Email</a>
</body>

</html>