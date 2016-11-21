<?php

namespace robske_110\PlateWarp;

use pocketmine\event\Listener;
#events...
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class EventListener implements Listener{
	private $plugin;

	public function __construct(PlateWarp $main){
		$this->main = $main;
		$this->server = $main->getServer();
		$this->server->getPluginManager()->registerEvents($main, $this);
	}
}
//Theory is when you know something, but it doesn't work. Practice is when something works, but you don't know why. Programmers combine theory and practice: Nothing works and they don't know why!