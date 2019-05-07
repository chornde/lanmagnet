<?php

	class SteamWebGrabber
	{
		public $urlschema = 'http://store.steampowered.com/app/%s/';
		public $titlepattern = '`<title>(.*) on Steam</title>`siU';
		
		public function GetGameDetails(string $appid){
			$url = sprintf($this->urlschema, $appid);
			$contents = file_get_contents($url);
			preg_match($this->titlepattern, $contents, $matches);
			$details['game']['gameName'] = $matches[1] ?? null;
			return $details;
		}
		
	}