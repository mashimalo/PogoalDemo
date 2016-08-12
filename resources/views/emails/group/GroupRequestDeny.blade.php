<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $userFullName }},<br>
    Your request to join <b>Group - {{$groupName}}</b> has been <b>rejected</b> by the group admin.<br>
    You can go to the {!!link_to($groupUrlLink ,'group page') !!} and send the request again.<br>
    <br>
    Thank you for using Pogoal.<br>
    <br>
    Pogoal Admin.<br>
</div>
</body>
</html>
