<?php

	define('config', require('config.php'));
	require('functions.php');
	require('Steam.php');
	require('SteamWebGrabber.php');
	
	class Worker {
		
		public function __construct($db, $Steam, $SteamWebGrabber){
			$this->db = $db;
			$this->Steam = $Steam;
			$this->SteamWebGrabber = $SteamWebGrabber;
		}
		
		public function run()
		{
			
			$mode = '';
			
			if(!empty($_GET['appid'])){
				$games = [['appid' => (int)$_GET['appid']]];
			}
			else {
				$games = $this->db->query('select appid from steamgames where name is null order by rand() limit 1');
				$mode = 'rand';
			}
			
			$update = $this->db->prepare('update steamgames set name = ? where appid = ?');
			
			foreach($games as $game)
			{
				$detailsstring = $this->Steam->GetSchemaForGame($game['appid']); # name by API
				$details = json_decode($detailsstring, true);
				
				if(empty($details['game']['gameName'])){ # fallback on web grabber
					$details = $this->SteamWebGrabber->GetGameDetails($game['appid']);
				}
				
				
				if(!empty($details['game']['gameName'])){ # update if name found
					$update->execute([$details['game']['gameName'], $game['appid']]);
				}
				
				pre($game['appid']);
				pre($details);
				
				if($mode == 'rand') echo '<script>setTimeout(function(){ window.location.reload(false); },1000);</script>';
				
				exit();
			}
		}
		
	}
	
	$db = new PDO(config['db']['dsn'], config['db']['user'], config['db']['pass']);
	$Worker = new Worker($db, new Steam($db), new SteamWebGrabber($db));
	$Worker->run();