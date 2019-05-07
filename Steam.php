<?php

	class Steam {

		public function __construct($db){
			$this->db = $db;
			$this->init();
		}

		public function init(){
			if(!file_exists(config['db']['initfile'])){
				$this->db->query('
					drop table if exists steamusers;
				');
				$this->db->query('
					drop table if exists steamgames;
				');
				$this->db->query('
					drop table if exists steamuser_owns_steamgame;
				');
				$this->db->query('
					create table steamusers(steamid varchar(100) primary key, personaname varchar(250), realname varchar(250), created datetime);
				');
				$this->db->query('
					create table steamgames(appid varchar(100) primary key, name varchar(250));
				');
				$this->db->query('
					create table steamuser_owns_steamgame(steamusers_steamid varchar(100), steamgames_appid varchar(100), primary key (steamusers_steamid, steamgames_appid));
				');
				file_put_contents(config['db']['initfile'], 'init');
			}
		}

		public function GetPlayerSummaries(string $id){
			$url = sprintf('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=%s&steamids=%s', config['steam']['api']['key'], $id);
			return file_get_contents($url);
		}

		public function GetOwnedGames(string $id){
			$url = sprintf('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=%s&steamid=%s', config['steam']['api']['key'], $id);
			return file_get_contents($url);
		}

		public function GetSchemaForGame(string $app){
			$url = sprintf('http://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=%s&appid=%s', config['steam']['api']['key'], $app);
			return file_get_contents($url);
		}

		public function add($id)
		{
			$newuser = $this->db->prepare('
				insert ignore into steamusers(steamid, personaname, realname, created)
				values(?, ?, ?, DATE("now"))
			');
			$newlink = $this->db->prepare('
				insert ignore into steamuser_owns_steamgame(steamusers_steamid, steamgames_appid)
				values(?, ?)
			');
			$newgame = $this->db->prepare('
				insert ignore into steamgames(appid)
				values (?)
			');

			$summarystring = $this->GetPlayerSummaries($id);
			$summary = json_decode($summarystring, true);
			if(!empty($summary['response']['players'][0]))
			{
				// add users
				$player = $summary['response']['players'][0];
				$newuser->execute([$player['steamid'], $player['personaname'], $player['realname'] ?? '']);
				
				$ownedgamesstring = $this->GetOwnedGames($player['steamid']);
				$ownedgames = json_decode($ownedgamesstring, true);
				if(!empty($ownedgames['response']['games']))
				{
					foreach($ownedgames['response']['games'] as $game)
					{
						// link owned games
						$newlink->execute([$player['steamid'], $game['appid']]);

						// insert games
						$newgame->execute([$game['appid']]);
					}
				}
			}
		}

		public function getUsers(){
			$users = $this->db->query('select * from steamusers');
			return $users;
		}

		public function getGames(){
			$games = $this->db->query('
				select
					*,
					(
						select count(*)
						from steamuser_owns_steamgame
						where steamgames_appid = sg.appid
					) as participants
				from steamgames sg
				
				order by participants desc, name asc
			');
			return $games;
		}

		public function GetOwnedGamesIndexed(){
			$indexed = [];
			$ownedgames = $this->db->query('select * from steamuser_owns_steamgame');
			foreach($ownedgames as $ownedgame){
				$indexed[$ownedgame['steamusers_steamid']][$ownedgame['steamgames_appid']] = true;
			}
			return $indexed;
		}

	}