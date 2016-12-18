<!DOCTYPE html>
<html>
	<head>
		<title>LAN Magnet</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Orbitron|Cambay" rel="stylesheet">
		<style>
html, body { margin:0; padding:0; font-family:Cambay; background-color:#052a2b; color:white; }
.name {
    display: flex;
    height: 100vh;
	margin-top:-5%;
    justify-content: center;
    align-items: center;
	font:bold 35px Orbitron;
	letter-spacing:3px;
	color:#fff;
	text-align:center;
	text-transform:uppercase;
}
.app { margin:5% 0 10% 0; text-align:center; }
.add, .add * { vertical-align:middle; }
input[type='number'] { padding:7px 10px; border:1px solid #008453; border-radius:15px; }
input[type='submit'] { width:30px; height:30px; padding:0; border:none; border-radius:100px; font-size:20px; background-color:#008453; color:white; text-align:center; }
table { width:90%; margin:0 5%; }
table tr {}
table tr th { height:110px; transform: rotate(45deg); vertical-align: middle; text-align: right; font-weight:normal;; }
table tr td { text-align:center; border-bottom:1px solid #008453; }
table tr td.has { font-weight:bold; color:lightgreen; }
table tr td.hasnot { color:grey; }
		</style>
	</head>
	<body>
		<div id="intro">
			<p class="name">LAN Magnet</p>
		</div>
		<div class="app">
			<div class="add">
				<form method="POST">
					<input type="number" name="steamid" value="" placeholder="Steam-ID eintragen" />
					<input type="submit" name="doAddSteamId" value="▶" />
				</form>
			</div>
			<div class="show">
				<table>
					<tr>
						<th><!-- game name column --></th>
						<th>borderschlanz</th>
						<th>LeaSt</th>
						<th>asgarhn</th>
						<th>budfenster</th>
					</tr>
					<tr>
						<td>Left4Dead</td>
						<td class="hasnot">✕</td>
						<td class="hasnot">✕</td>
						<td class="hasnot">✕</td>
						<td class="has">✓</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>