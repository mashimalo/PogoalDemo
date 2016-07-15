<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ $title }}</h2>

		<div>
			{!! $intro . link_to('auth/confirm/' . $confirmation_code, $link) !!}.
			<br>
			<br>
			Thanks!
			<br>
			Pogoal Admin
		</div>
	</body>
</html>
