<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $targetGroupAdminUserFullName }},<br>
    {!!link_to($sourceGroupUrlLink ,$sourceGroupName) !!} is requesting to start a bridging session with your <b>Group - {{$targetGroupName}}</b>.<br>
    Please click {!!link_to($targetGroupNotificationUrlLink ,'here') !!} to process the request. <br>
    <br>
    Thank you for using Pogoal.<br>
    <br>
    Pogoal Admin.<br>
</div>
</body>
</html>
