<?php

	/*
		todo:
		- neue LANs als YML
		- Alles noch mal sammeln aus den verschiedenen Formaten
		- mobile Tabelle
		- alle LANs mit ID versehen
		- ical export https://stackoverflow.com/questions/5329529/i-want-html-link-to-ics-file-to-open-in-calendar-app-when-clicked-currently-op
	*/

	class Filter {
	    public static function ofthepast(string $key){
	        $now = new DateTime();
	        return function($item) use ($key, $now){
	            return (new DateTime($item->$key)) <= $now;
            };
        }

	    public static function inthefuture(string $key){
            $now = new DateTime();
            return function($item) use ($key, $now){
                return (new DateTime($item->$key)) > $now;
            };
        }
    }

	class Sort {
	    public static function byKey(string $key){
	        return function($a, $b) use ($key){
	            return $a->$key <=> $b->$key;
            };
        }
    }

	class LanConnector {
        protected $lans = [];

        public function __construct(string $file){
            $lans = yaml_parse_file($file);
            foreach($lans as $lan){
                $this->lans[] = (object)$lan;
            }
        }

        public function sort(Closure $sort, bool $reverse = false) : self {
            usort($this->lans, $sort);
            $this->lans = $reverse ? array_reverse($this->lans) : $this->lans ;
            return $this;
        }

        public function ofthepast() : Generator {
            foreach(array_filter($this->lans, Filter::ofthepast('end')) as $lan) yield $lan;
        }

        public function inthefuture() : Generator {
            foreach(array_filter($this->lans, Filter::inthefuture('end')) as $lan) yield $lan;
        }

        public function fetch() : Generator {
            foreach($this->lans as $lan) yield $lan;
        }

        public function fetchAll() : array {
            return $this->lans;
        }
    }

    $lans = (new LanConnector($config['lans']['file']));
    $lans->sort(Sort::byKey('start'));

	$ternaries = [
		true  => '✓',
		false => '✕',
		null  => '‽',
	];

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
					<?php foreach($lans->ofthepast() as $lan): ?>
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
					<?php foreach($lans->inthefuture() as $lan): ?>
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