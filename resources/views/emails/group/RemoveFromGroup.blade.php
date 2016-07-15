<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $userFullName }},<br>
    Your have been <b>REMOVED</b> from <b> {{$groupName}} </b> by the group admin.<br>
    Please click {!!link_to($groupUrlLink ,'here') !!} and look for other groups to join.
    <br>
    Thank you for using Pogoal.<br>
    <br>
    Pogoal Admin.<br>
</div>
</body>
</html>
