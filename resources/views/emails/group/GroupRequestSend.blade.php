<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $adminUserFullName }},<br>
    {{ $pendingUserFullName }} is looking to join your <b>Group -  {{$groupName}} </b> !!!<br>
    Please click {!!link_to($groupNotificationUrlLink ,'here') !!} to accept/deny the request. <br>
    <br>
    Thanks you for using Pogoal.<br>
    <br>
    Pogoal Admin.<br>
</div>
</body>
</html>
