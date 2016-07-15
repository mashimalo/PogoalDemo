<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $recipientUserName }},<br>
    Your <b>Group -  {!!link_to($pendingDockingRequestGroupUrlLink ,$pendingDockingRequestGroupName) !!} bridging request with <b>Group - {!!link_to($sourceGroupUrlLink ,$sourceGroupName) !!} has been denied.<br>
    Please visit <b>{!!link_to($sourceGroupUrlLink ,$sourceGroupName) !!}'s</b> group page and try again.<br>
    <br>
    Thank you for using Pogoal. <br>
    <br>
    Pogoal Admin.<br>
</div>
</body>
</html>
