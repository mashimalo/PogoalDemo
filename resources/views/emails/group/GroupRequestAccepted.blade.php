<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $userFullName }},<br>
    Your request to join <b>Group -  {{$groupName}} </b> has been <b>accepted</b> by the group admin.<br>
    Please click {!!link_to($groupUrlLink ,'here') !!} to visit the Group Page and have fun.<br>
    <br>
    Thank you for using Pogoal.<br>
    <br>
    Pogoal Admin.<br>
</div>
</body>
</html>
