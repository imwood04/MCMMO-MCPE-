<?php

namespace imwood04\AlexPads\Mcmmo

use pocketmine\player;
use pocketmine\
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

/** @var Database */
	private $database;

class Main extends PluginBase implements Listener{
  
  public function onEnable() : void{
		$this->saveResource("something.yml");
		$this->saveResource("somename.ini");
    
		McMMOCommand::registerDefaults($this);
		SkillCommand::loadHelpPages($this->getDataFolder() . "something.ini");
		SkillManager::registerDefaults();
    
		$database = new Config($this->getDataFolder() . "something.yml");
		$dbtype = $database->get("type");
		$args = $database->get(strtoupper($dbtype));
    $this->database = Database::getFromString($dbtype, $this->getDataFolder() . $args["datafolder"] . DIRECTORY_SEPARATOR);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    
	}
	public function onDisable() : void{
		$this->getDatabase()->saveAll();
		$this->getDatabase()->onClose();
	}
	public function getDatabase() : Database{
		return $this->database;
	}
	public function getSkillManager(Player $player) : SkillManager{
		return $this->database->getLoaded($player);
	}
}

  ///this allows us to have multiple files in the folder and a .php for each type eg. Miner, Acrobatics, so-on and 
 /// this is what i did and so you can check it :)
