<?php

	/*
		todo:
		- neue LANs als YML
		- Alles noch mal sammeln aus den verschiedenen Formaten
		- mobile Tabelle
		- alle LANs mit ID versehen
		- ical export https://stackoverflow.com/questions/5329529/i-want-html-link-to-ics-file-to-open-in-calendar-app-when-clicked-currently-op
	*/



	function landatacsv($out, $string, $delim = "\n", $sep = ","){
		$lines = explode($delim, $string);
		foreach($lines as $line){
			$columns = explode($sep, $line);
			list($from, $to) = explode('-', $columns[1]);
			$from .= '2018';
			$start = (new DateTime($from))->format('Y-m-d');
			$to .= '2018';
			$end = (new DateTime($to))->format('Y-m-d');
			$part = $columns[6] === '' ? null : ($columns[6] === '0' ? false : true ) ;
			$price = $columns[3] === '' ? null : $columns[3] ;
			$out[] = [$columns[0],$columns[2],$columns[1],$start,$end,$price,$columns[4],$columns[5],$part,];
		}
		return $out;
	}

	$ternaries = [
		true  => '✓',
		false => '✕',
		null  => '‽',
	];

	# 2017

	$landata2017 = [
		['GyBraLAN', 'Hamburg', '17. - 19.3.', '2017-03-17', '2017-03-19', 10, 80, 'http://www.gybralanre.de/', true],
		['genial verpLANt', 'Brake', '7. - 9.4.', '2017-04-07', '2017-04-09', 20, 200, 'http://www.total-verplant.de', null],
		['OstfriesLAN', '26409, Wittmund', '21. - 23.4.', '2017-04-21', '2017-04-23', 25, 100, 'http://www.ostfrieslan.de', true],
		['SüdseeLAN', 'Braunschweig', '21. - 23.4.', '2017-04-21', '2017-04-23', 15, 50, 'https://docs.google.com/forms/d/e/1FAIpQLSdMqnFBcg7LTwFiaTvrRijSUMHe3ZlQi9c8xOAkNcJgBsHJnA/viewform?c=0&w=1', null],
		['GSH-Lan', 'Hannover/Garbsen', '21. - 23.4.', '2017-04-21', '2017-04-23', 35, 600, 'http://www.gsh-lan.com/', null],
		['MoinMoinLAN', 'Bremerhaven', '12. - 14.5.', '2017-05-12', '2017-05-14', 10, 35, 'http://www.moinmoinlan.de/', true],
		['LANresort', 'Bispingen', '12. - 15.5.', '2017-05-12', '2017-05-15', 100, 300, 'https://www.lanresort.de/', null],
		['the-encounter: three', '49808, Lingen', '19. - 21.5.', '2017-05-19', '2017-05-21', 10, 60, 'http://www.the-encounter.de/', null],
		['play germany', 'Hannover/Burgdorf', '25. - 28.5.', '2017-05-25', '2017-05-28', 30, 80, 'http://www.pg-lan.de/', null],
		['MultiMadness', 'Hamburg', '9. - 11.6.', '2017-06-09', '2017-06-11', 30, 200, 'https://www.multimadness.de', null],
		['NGC', '25813, Husum', '5. - 8.10.', '2017-10-05', '2017-10-08', 60, 500, 'https://www.ngc-germany.de/', null],
		['genial verpLANt #23', '26919 Brake', '6. - 8.10.', '2017-10-06', '2017-10-08', 18, 200, 'https://www.total-verplant.de', null],
		['Maxlan', 'Meppen', '17. - 19.11.', '2017-11-17', '2017-11-19', 30, 210, 'http://www.maxlan.de/', null],
		['Rofl-LAN', 'Cuxhaven', '1. - 3.12.', '2017-12-01', '2017-12-03', 13, 120, 'http://www.rofl-lan.de', null],
		['Northcon', '24537 Neumünster', '14. - 17.12.', '2017-12-14', '2017-12-17', 69, 1300, 'https://www.northcon.de', null],
	];

	# 2018

	$landata2018 = <<<'LANDATA2018'
Northcon,13.12.-16.12.,24537 Neumünster,,1000,https://www.northcon.de/infos/ueberblick,
LANresort,20.04.-23.04.,29646 Bispingen,,400,https://www.lanresort.de/infos/ueberblick,
GyBraLAN:RE 6,23.2.-25.02.,22175 Hamburg Bramfeld,10,98,http://www.gybralanre.de/index.php?mod=info2&action=show_info2&id=5,
genial verpLANt #24,23.3.-25.3.,26919 Brake,18,200,https://www.total-verplant.de/party/?do=event,
SüdseeLAN,23.2.-25.2.,Braunschweig,20,50,https://sites.google.com/view/suedseelan,
GSH 2018 #1,23.3.-25.3.,30827 Garbsen,35,600,http://www.gsh-lan.com/party/?do=event,
Boot:up LAN,18.5.-21.5.,40474 Düsseldorf,99,2500,https://www.bootup-lan.de/de/infos,
MoinMoin V,29.6.-01.07.,27572 Bremerhaven,10,35,https://www.moinmoinlan.de,1
Play-Germany LAN #4,4.5.-6.5.,31303 Burgdorf,25,150,http://portal.pg-lan.de/party/?do=event,
MultiMadness 36,1.6.-3.6.,21220 Seevetal-Maschen,30,200,https://www.multimadness.de/?page=3,1
NGC 2018,06.09.-09.09.,25813 Husum,60,500,https://www.ngc-germany.de/de/content/sicher-dir-noch-dein-ticket,
Maxlan 27,2.11.-4.11.,49716 Meppen,40,228,https://www.maxlan.de/party/?do=event,
Springe-LAN,24.3.-25.3.,31832 Springe/Hannover,0,22,https://www.acgc.de/veranstaltungsanmeldung/,
Fette Lan,21.4.-22.4.,38350 Helmstedt,5,28,http://fettelan.de/termine/,
LaWa #08/15,27.4.-29.4.,59602 Rüthen,20,36,http://www.la-wa.com/?action=info,
#TSF18,14.6.-17.6.,30521 Hannover/Expo,120,2500,https://tek.ag/,
BoerdeLAN 26,29.6.-1.7.,59581 Warstein,40,400,https://www.boerde-lan.de/party/?do=event&id=26,
PyrateLAN #2,21.9.-23.9.,24784 Westerrönfeld,29,110,https://pyratelan.de/party/?do=event,
genial verpLANt,5.10.-7.10.,26919 Brake,35,200,https://www.total-verplant.de,1
LAN Schwanewede,05.10.-7.10.,Schwanewede,?,?,http://www.lan-schwanewede.de,
ostfriesLAN,12.10.-14.10.,Wittmund,40,100,https://ostfrieslan.de/,1
LAN-Party-Wehdem,3.11.-4.11.,32351 Wehdem/Stemwede,5,56,https://www.lanparty-wehdem.de,0
Ro.Fl.-LAN 5,9.11.-11.11.,27474 Cuxhaven,15,120,http://www.rofl-crew.de/party/?do=event,1
LANDATA2018;

	$landata2018 = landatacsv($landata, $landata2018);

	# 2019

	$landata2019 = [
		['MoinMoinLAN VI', '27572, Bremerhaven', '25. - 27.1.', '2019-01-25', '2019-01-27', 10, 28, 'http://www.moinmoinlan.de', true],
		['GamePlay', 'Weyhe/Leeste', '26. - 27.1.', '2019-01-26', '2019-01-27', 15, null, 'https://gameplaylan.de/Events', null],
		['the-encounter: five', '49808 Lingen', '22. - 24.2.', '2019-02-22', '2019-02-24', 8, 80, 'https://the-encounter.de', null],
		['GyBraLAN:RE 7', '22179, Hamburg', '22. - 24.2.', '2019-02-22', '2019-02-24', 10, 100, 'http://www.gybralanre.de/', true],
		['PADERSMASH', '33102 Paderborn', '16. - 16.3.', '2019-03-16', '2019-03-16', null, 64, 'https://lan-party.org/', null],
		['genial verpLANt #26', '26919 Brake', '12. - 14.4.', '2019-04-12', '2019-04-14', 18, 200, 'https://www.total-verplant.de/', true],
		['NETCONVENT #51', '38239 Salzgitter', '5. - 7.4.', '2019-04-05', '2019-04-07', 15, 40, 'https://netconvent.net', null],
		['GSH 2019 #1', 'Hannover', '12. - 14.4.', '2019-04-12', '2019-04-14', 35, 600, 'https://www.gsh-lan.com/', false],
		['LaWa #17', '59602 Rüthen', '26. - 28.4.', '2019-04-26', '2019-04-28', 20, 36, 'http://www.la-wa.com', false],
		['BoerdeLAN', '59581 Warstein', '10. - 12.5.', '2019-05-10', '2019-05-12', 40, 400, 'https://boerde-lan.de/home/', null],
		['LANresort', '29646 Bispingen', '3. - 6.5.', '2019-05-03', '2019-05-06', 150, 394, 'https://www.lanresort.de', null],
		['Multimadness 37', '21220, Maschen', '14. - 16.6.', '2019-06-14', '2019-06-16', 30, 200, 'http://www.multimadness.de/', true],
		['Fette LAN #7', '38350 Helmstedt', '4. - 6.1.', '2019-01-04', '2019-01-06', 10, 60, 'http://www.fettelan.de/', null],
		['Fette LAN #8', '38350 Helmstedt', '8. - 10.3.', '2019-03-08', '2019-03-10', 10, 60, 'http://www.fettelan.de/', null],
		['Fette LAN #9', '38350 Helmstedt', '10. - 12.5.', '2019-05-10', '2019-05-12', 10, 60, 'http://www.fettelan.de/', null],
		['GamePlay', '28844 Weyhe', '5. - 7.7.', '2019-07-05', '2019-07-07', 25, 60, 'https://gameplaylan.de/', true],
		['Fette LAN #10', '38350 Helmstedt', '12. - 14.7.', '2019-07-12', '2019-07-14', 10, 60, 'http://www.fettelan.de/', null],
		['Optimal LAN', '38373 Süpplingen', '12. - 14.7.', '2019-07-12', '2019-07-14', 20, 60, 'https://www.tatami-suepplingen.de/e-sport/optimal-lan-party/', null],
		['the-encounter: summer edition', '49808 Lingen', '16. - 18.8.', '2019-08-16', '2019-08-18', 8, 86, 'https://the-encounter.de', null],
		['Fette LAN #11', '38350 Helmstedt', '20. - 22.9.', '2019-09-20', '2019-09-22', 10, 60, 'http://www.fettelan.de/', null],
		['NGC', '25813 Husum', '3. - 6.10.', '2019-10-03', '2019-10-06', 60, 550, 'https://www.ngc-germany.de', null],
		['GSH 2019 #2', 'Hannover', '11. - 13.10.', '2019-10-11', '2019-10-13', 35, 600, 'https://www.gsh-lan.com/', true],
		['genial verpLANt 27', '26919 Brake', '11. - 13.10.', '2019-10-11', '2019-10-13', 20, 200, 'https://www.total-verplant.de/party/?do=event/', false],
		['LAN Schwanewede', '28790 Schwanewede', '18. - 20.10.', '2019-10-18', '2019-10-20', 10, 60, 'http://www.lan-schwanewede.de/', null],
		['SüdseeLAN', 'Braunschweig', '25. - 27.10.', '2019-10-25', '2019-10-27', 20, 50, 'https://sites.google.com/view/suedseelan/', null],
		['PyrateLAN #3', '24784 Westerrönfeld', '1. - 3.11.', '2019-11-01', '2019-11-03', 25, 87, 'https://pyratelan.de/', null],
		['Maxlan 28', '49716 Meppen', '1. - 3.11.', '2019-11-01', '2019-11-03', 29, 228, 'http://www.maxlan.de/', null],
		['Fette LAN #12', '38350 Helmstedt', '8. - 10.11.', '2019-11-08', '2019-11-10', 10, 60, 'http://www.fettelan.de/', null],
		['Ro.Fl. - Lan 6 on the beach', 'Cuxhaven', '15. - 17.11.', '2019-11-15', '2019-11-17', 17, 70, 'http://www.rofl-lan.de/', true],
		['Northcon', 'Neumünster', '12. - 15.12.', '2019-12-12', '2019-12-15', null, 1300, 'https://www.northcon.de', null],
	];
	
	
	$landata = array_merge($landata2017, $landata2018, $landata2019);

	foosort($landata, 3);

	fooflag($landata);

	$lanmap = ['name', 'location', 'date', 'start', 'end', 'price', 'participants', 'link', 'participation', 'is_future', 'year'];

	$lans = compose($lanmap, $landata);
	yaml_emit_file('lans.yml', json_decode(json_encode($lans), true));
	pre(yaml_parse_file('lans.yml'));
	$futurelans = array_filter($lans, function($lan){ return $lan->is_future; });
	$pastlans = array_filter($lans, function($lan){ return !$lan->is_future; });

?>
<!DOCTYPE html>
<html>
	<head>
		<title>LAN Magnet</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Khula|Saira+Condensed" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
		<script>
			$(document).ready(function(){
				$('.fa-map-marker-alt').click(function(){
					if (!navigator.geolocation) { 
						alert('Standortabfrage in Ihrem Browser leider nicht möglich.');
						return;
					}
					navigator.geolocation.getCurrentPosition(
						function(position){
							console.log(position);
							location.href = "/?lat="+position.coords.latitude+"&lon="+position.coords.longitude;
						},
						function(){
							alert('Für die Berechnung der Entfernung ist eine Standortabfrage erforderlich. Diese Daten werden nicht gespeichert.');
						}
					);
				});
			});
		</script>
		<style>
html, body { margin:0; padding:0; font-family:'Khula'; background-color:#052a2b; color:white; }
h1, h2 { font-family: 'Saira Condensed'; letter-spacing:1px; }
a { text-decoration:none; color:lightgreen; }
input[type='number'] { padding:7px 10px; border:2px solid #008453; border-radius:15px; }
input[type='submit'] { width:30px; height:30px; border:none; border-radius:100px; font-size:20px; background-color:#008453; color:white; text-align:center; vertical-align:center; }
table { width:90%; margin:25px 5% 0; border-collapse:collapse; }
table tr {}
table tr th, table tr td { padding:5px; }
table tr th { text-align:left; font-weight:normal; }
table tr td { text-align:left; border-bottom:1px solid #005f3b; }
table tr td.has { font-weight:bold; color:lightgreen; }
table tr td.hasnot { color:grey; }
tr.year td { font-style:italic; font-weight:bold; }
ul { padding:0; list-style-type:none; }
li { text-align:center; }
button { margin:25px; padding:5px 10px; border:none; font-size:15px; background-color:#005f3b; color:lightgreen; }
#intro { display:none; }
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
.block { margin:2.5% 0 5% 0; }
.add, .add * { vertical-align:middle; }
.games table tr td a { padding-left:10px; }
.hint { color:grey; }
.future_yes {}
.future_no { display:none; }
.future_no, .future_no * { color:grey; }
.ternaryicon.✓ { color:lightgreen; }
.ternaryicon.✕ { color:darkgrey; }
.ternaryicon.‽  { color:grey; }
.fa-map-marker-alt { padding-left:10px; cursor:pointer; }


@media (max-width: 360px) {
	table { width:97%; margin:25px 1% 0; }
	table tr th:nth-child(1) { width:25%; }
	table tr th:nth-child(2) { width:20%; }
	table tr th:nth-child(3) { width:20%; }
	table tr th:nth-child(4) { width:12.5%; }
	table tr th:nth-child(5) { width:12.5%; }
	table tr th:nth-child(6) { width:2.5%; }
	table tr th, table tr td { padding:3px 1px 0px; font-size:.8rem; }
	table tr th:nth-child(4), table tr td:nth-child(4) { text-align:center; }
}


		</style>
	</head>
	<body>
		<div id="intro">
			<p class="name">LAN Magnet</p>
		</div>
		<div class="app">

			<div class="block lanplan">
				<h1>LAN-Plan für Nord/West Deutschland</h1>
				<table id="lanstable">
					<tr>
						<th>Name</th>
						<th>Datum</th>
						<th>Ort</th>
						<th>Preis</th>
						<th>Teiln.</th>
						<th></th>
					</tr>
					<?php $lastyear = 0; ?>
					<?php foreach($pastlans as $lan): ?>
						<?php if($lan->year != $lastyear): ?>
							<tr class="year future_no">
								<td colspan=7><?=$lan->year?></td>
							</tr>
							<?php $lastyear = $lan->year; ?>
						<?php endif; ?>
						<tr class="future_no">
							<td><a href="<?=$lan->link?>" target="_blank"><?=$lan->name?><a></td>
							<td><?=$lan->date?></td>
							<td><?=$lan->location?> <!--<i class="fas fa-map-marker-alt"></i>--></td>
							<td><?=$lan->price === null ? '‽' : $lan->price.'€'?></td>
							<td><?=$lan->participants?></td>
							<td><span class="ternaryicon <?=$ternaries[$lan->participation]?>"><?=$ternaries[$lan->participation]?></span></td>
						</tr>
					<?php endforeach; ?>
					<?php foreach($futurelans as $lan): ?>
						<?php if($lan->year != $lastyear): ?>
							<tr class="year">
								<td colspan=7><?=$lan->year?></td>
							</tr>
							<?php $lastyear = $lan->year; ?>
						<?php endif; ?>
						<tr class="future_yes">
							<td><a href="<?=$lan->link?>" target="_blank"><?=$lan->name?><a></td>
							<td><?=$lan->date?></td>
							<td><a href="https://www.google.de/maps/place/<?=$lan->location?>/" target="_blank"><?=$lan->location?></a></td>
							<td><?=$lan->price === null ? '‽' : $lan->price.'€'?></td>
							<td><?=$lan->participants?></td>
							<td><span class="ternaryicon <?=$ternaries[$lan->participation]?>"><?=$ternaries[$lan->participation]?></span></td>
						</tr>
					<?php endforeach; ?>
				</table>
				<button id="show_lan_archive">LAN-Archiv anzeigen</button>
			</div>

			<div class="block">
				<h1>... noch mehr LANs</h1>
				<h4><a href="https://lan-map.de/" target="_blank">LAN-Map.de</a></h4>
			</div>
			
			<div class="block">
				<h1>LAN Packliste</h1>
				<ul>
					<li>3er Steckdose</li>
					<li>Tower + Stromkabel, LAN-Kabel | Notebook + Netzteil</li>
					<li>Monitor + Strom/VGA/DVI/HDMI/DP-Kabel</li>
					<li>Tastatur, Maus, Mauspad, Gamepad, Headset, externe Platten</li>
					<li>Essen + Trinken, Geld</li>
					<li>Isomatte, Schlafsack, Decke, Kissen</li>
				</ul>
			</div>

			<?php /*<div class="block steamlist">
				<h1>Gamelist</h1>
				<div class="add">
					<form method="POST">
						<input type="number" name="steamid" value="" placeholder="Steam-ID eintragen" />
						<input type="submit" name="doAddSteamId" value="▶" />
					</form>
				</div>
				<div class="games">
					<table>
						<tr>
							<th><!-- game name column --></th>
							<?php foreach($Steam->getUsers() as $user): ?>
								<th><?=$user['personaname']?></th>
							<?php endforeach; ?>
						</tr>
						<?php $indexed = $Steam->GetOwnedGamesIndexed(); ?>
						<?php foreach($Steam->getGames() as $game): ?>
							<?php if(substr($game['name'], 0, 12) != 'ValveTestApp'): ?>
								<tr>
									<td class="<?php echo ($game['name']) ? '' : 'hint' ; ?>"><?=$game['name']?:'(wird ermittelt...)'?> <a href="http://store.steampowered.com/app/<?=$game['appid']?>/" target="_blank">↗</a></td>
									<?php foreach($Steam->getUsers() as $user): ?>
										<?php $has = isset($indexed[$user['steamid']][$game['appid']]); ?>
										<td class="<?php echo ($has) ? 'has' : 'hasnot' ; ?>"><?php echo ($has) ? '✓' : '✕' ; ?></td>
									<?php endforeach; ?>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</table>
				</div>
			</div>*/?>

			<div class="block">
				<h1>Impressum</h1>
				<h4>(wegen <a href="https://gybralanre.de/" target="_blank">Nightwolf</a> :D)</h4>
				<h2>Angaben gem&auml;&szlig; &sect; 5 TMG:</h2>
				<p>Christian Horn<br />K&ouml;tnerdamm 10<br />27283 Verden</p>
				<h2>Kontakt:</h2> <p>Telefon: +49 (0) 160 929 11 77 3<br />E-Mail: impressum@drouvec.de</p>
				<p>Quelle: <a href="https://www.e-recht24.de/impressumgenerator.html">https://www.e-recht24.de/impressum-generator.html</a></p>
			</div>
			
		</div>
		
		<script type="text/javascript">
			$('#show_lan_archive').click(function(){
				$('.future_no').toggle();
				$('#show_lan_archive').hide();
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			});
		</script>
	</body>
</html>

<!--

Genug von Wahlversprechen? Diese Urteile sind bereits gefällt und treten mit der Amtsübernahme in Kraft:

	- Verbot der Einfuhr und des Verkaufs von Kleidung mit Echtpelz
	- betäubungslose Kastration ist verboten und wird mit mindestens einem Jahr Freiheitsstrafe belegt
	- medizinisch nicht notwendige Beschneidung wird mit mindestens einem Jahr Freiheitsstrafe belegt; keine Verjährungsfrist
	- § 811c Absatz zwei wird gestrichen
	- Das Gesetzt für "Uploadfilter" wird aufgehoben
	- das Verbot gegen Holocaustleugnung wird aufgehoben, es werden Belge gesammelt und veröffentlicht
	- Mein Kampf wird verpflichtende Schullektüre im Geschichtsunterricht zur Manipulationsprävention
	- Religionsunterricht wird durch das Fach Mythologie ersetzt, es werden gewaltverherrlichende Themen aufgegriffen
	- wer Freitags die Schule schwänzt geht Samstag und Sonntag in den Knast
	- GEZ 5€ pro Monat und Person, Eindämmung externer Dienstleister, keine Werbung, neues Soldmodell mit drastisch beschnittenen Gehältern, Beamtenstatus aberkennen
	- Volksabstimmungen nach Schweizer Modell
	- Laienwörter wie "wirksam" wie in "es sind wirksame Maßnahmen zu treffen" wird aus Gesetzestexten entfernt, Politiker und Juristen werden sich nicht vor der technsichen Realität drücken 
	- Haftstrafen für Züchter und Importeure deren Züchtungen zur Einschränkung der Lebensqualität führen   https://www.bz-berlin.de/berlin/steglitz-zehlendorf/die-menschen-ahnen-gar-nicht-was-sie-ihren-haustieren-antun
	- die Bevölkerung erhält das Recht über die Wehrhaftigkeit des Landes informiert zu sein   https://augengeradeaus.net/2019/03/zahlen-zur-einsatzbereitschaft-von-bundeswehr-waffensystemen-bisher-offen-jetzt-geheim/
	- Die Bundeswehr wird in die Lage versetzt ihre Waffensysteme selbst instand zu halten; gegenteilige Verträge werden gekündigt   https://www.epochtimes.de/politik/deutschland/bundeswehr-darf-viele-waffensysteme-nicht-selbst-reparieren-und-bei-reparatur-nicht-zusehen-a2804810.html
	- http://www.danisch.de/blog/2019/04/07/pressemitteilung-zu-fluechtlingen/
	- Wirtschaftsinteressen in den Hintergrund drängen (Milch "Milch", Burger "Burger", Schnitzel etc.)
	- oder konsequente Durchsetzung, "Milch"strasse abschaffen, Kakao"Butter" verboten
	- "die Bürger wollen genau wissen was sie essen" lasse ich mir nicht von jemandem sagen der nur das Etikett und nicht die Zutatenliste liest   https://www.bento.de/essen/veggie-burger-die-eu-will-das-wort-verbieten-und-langsam-reicht-s-a-5b1967c8-47ee-437f-85fe-8122d20644d7
	- Alkoholverbot in allen öffentlichen Einrichtungen, Dienststrafen
	- Ablehnung aller EU Maßnahmen ohne ein tragbares Konzept; Verantwortung nicht auf Deutschland abwälzen; ggf. Sanktionen in Kauf nehmen; Neubewertung des EU-Beitritts
	- Befindlichkeiten einschränken, Straffen für Erregung öffentlichen Ärgernisses dämpfen   https://www.bz-berlin.de/tatort/menschen-vor-gericht/oralverkehr-in-berliner-s-bahn-kostet-paar-7500-euro
	
	ABSCHNITT POLITICAL CORRECTNESS
	
	- mehr Gehör für Systemkritiker, mehr Aufdeckung, mehr unerwünschte Meinung   https://www.heise.de/tp/features/Massenvernichtungswaffe-Uranmunition-4350706.html?seite=2
	
	ABSCHNITT SEKULARISIERUNG
	
	- Bundesfördermittelüberprüfung von Religions- und Privatschulen und ggf. Einstellung dieser

-->