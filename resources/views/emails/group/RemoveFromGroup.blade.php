<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $userFullName }},<br>
    Your have been <b>removed</b> from <b> Group - {{$groupName}} </b> by the group admin.<br>
    You can click {!!link_to($groupUrlLink ,'here') !!} to revisit the group and send the join request again.
    <br>
    Thank you for using Pogoal.<br>
    <br>
    Pogoal Admin.<br>
</div>
</body>
</html>
