<?php

	class Steam {
		
		public function __construct($config, $db){
			$this->config = $config;
			$this->db = $db;
			$this->init();
		}
		
		public function init(){
			return;
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
				create table steamuser_owns_steamgame(steamusers_steamid varchar(100), steamgames_appid varchar(100));
			');
		}
		
		public function GetPlayerSummaries(string $id){
			$url = sprintf('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=%s&steamids=%s', $this->config['api']['key'], $id);
			return file_get_contents($url);
		}
		
		public function GetOwnedGames(string $id){
			$url = sprintf('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=%s&steamid=%s', $this->config['api']['key'], $id);
			return file_get_contents($url);
		}
		
		public function GetSchemaForGame(string $app){
			$url = sprintf('http://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=%s&appid=%s', $this->config['api']['key'], $app);
			return file_get_contents($url);
		}
		
		public function add($id){ return;
			$summarystring = $this->GetPlayerSummaries($id);
			$summary = json_decode($summarystring, true);
			if(!empty($summary['response']['players'][0])){
				$player = $summary['response']['players'][0];
				$insert = $this->db->prepare('
					insert into steamusers(steamid, personaname, realname, created)
					values(?, ?, ?, NOW())
				');
				$insert->execute([$player['steamid'], $player['personaname'], $player['realname']]);
				// add games
				$ownedgamesstring = $this->GetOwnedGames($player['steamid']);
				$ownedgames = json_decode($ownedgamesstring, true);
				if(!empty($summary['response']['games'])){
					foreach($summary['response']['games'] as $game){
						$link = $this->db->prepare('
							insert into steamuser_owns_steamgame(steamid, appid)
							values(?, ?)
						');
						$link->execute([$player['steamid'], $game['appid']]);
						$newgame = $this->db->prepare('
							insert or ignore into steamgames(appid, name)
							values (?, ?)
						');
						$newgame->execute([$game['appid'],$game['gameName']]);
					}
				}
			}
		}
		
	}