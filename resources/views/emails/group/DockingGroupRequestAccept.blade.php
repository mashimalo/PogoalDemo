<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $recipientUserName }},<br>
    <b>Group - {!!link_to($pendingDockingRequestGroupUrlLink ,$pendingDockingRequestGroupName) !!} </b> is now <b>briding with Group - {!!link_to($sourceGroupUrlLink ,$sourceGroupName) !!} </b> !!!<br>
    Please click {!!link_to($dockingGroupUrl ,'here') !!} to the bridge group page and start chatting. <br>
    <br>
    Have fun!<br>
    <br>
    Thanks you for using Pogoal.<br>
    <br>
    Pogoal Admin.<br>
</div>
</body>
</html>
