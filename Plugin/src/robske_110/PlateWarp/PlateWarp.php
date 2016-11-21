<?php
namespace robske_110\PlateWarp;


use robske_110\PlateWarp\api\PlateWarpAPI;
use robske_110\PlateWarp\cmd\AddWarpCommand;
use robske_110\PlateWarp\cmd\CloseWarpCommand;
use robske_110\PlateWarp\cmd\DelWarpCommand;
use robske_110\PlateWarp\lang\Translator;
use robske_110\PlateWarp\Utils;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class PlateWarp extends PluginBase{
	const CODENAME = "Only people you care about can hurt you";
	const SIMPLE_WARP_VERSION_RECOMMENDED = "3.2.0";
	const SIMPLE_WARP_VERSION_MIN = "3.2.0";
	
    /** @var  PlateWarpApi */
    private $api;
    /** @var  WarpManager */
    private $warpManager;
    /** @var  Translator */
    private $translator;

    public function onEnable(){
		file_put_contents($this->getDataFolder() . ".started", "onEnableStart");
		$this->getServer()->getLogger()->info(TF::GREEN."This is ".TF::DARK_GREEN.$this->getDescription()->getFullName().TF::GRAY."[".TF::DARK_GRAY.self::CODENAME.TF::GRAY."]".TF::GREEN." for ".TF::DARK_GREEN."SimpleWarp v".self::SIMPLE_WARP_VERSION_RECOMMENDED.".");
		
        $this->saveDefaultConfig();
		Utils::init($this, $this->getConfig()->get('debug-to-file'));
		if(version_compare($this->getServer()->getPluginManager()->getPlugin("SimpleWarp")->getPluginDescriptio()->getVersion(), self::SIMPLE_WARP_VERSION_MIN, '<')){
			Utils::critical("You are using an outdated SimpleWarp. This might lead to crashes!"."Please use SimpleWarp v".self::SIMPLE_WARP_VERSION_RECOMMENDED);
		}
		
        $this->shownNotices = new Config($this->getDataFolder() . ".shownNotices", Config::ENUM, []);
        $this->shownNotices->save();
		
		if(!$this->isPhar() && !$this->shownNotices->exists("package")){
			Utils::notice("PlateWarp is not packaged!");
			$this->shownNotices->set("package");
			$this->shownNotices->save();
		}
		
        $this->translator = new Translator($this, $this->getServer(), $this->getConfig()->get("lang"));
		/*
		$this->api = new PlateWarpAPI($this);
        $this->warpManager = new WarpManager($this);
        $this->getServer()->getCommandMap()->registerAll("PlateWarp", [
            new AddPlateWaro($this),
            new RemPlateWarp($this),
		 	new ListPlateWarp($this)
        ]);
		$this->eventHandler = new EvenHandler($this, $this->warpManager);
		*/
        if(file_exists($this->getDataFolder().".started")){
            Utils::critical("PlateWarp was not disabled correctly!");
        }
        file_put_contents($this->getDataFolder() . ".started", "onEnableDone");
    }
	
    public function onDisable(){
        $this->warpManager->close(); #shutUp!
        unlink($this->getDataFolder() . ".started");
        if(file_exists($this->getDataFolder() . ".started")){
            $this->getLogger()->alert("Unable to clean up session file. You will be shown an error next time you start. Please ignore it.");
        }
    }
	
    public function getWarpManager(): WarpManager{
        return $this->warpManager;
    }
	
	public function getTranslator(): Translator{
		return $this->translator;
	}

    public function getApi(): PlateWarpAPI{
        return $this->api;
    }

    /**
     * Function to easily disable commands
     *
     * @param array $commands
     */
    private function unregisterCommands(array $commands){
        $commandMap = $this->getServer()->getCommandMap();
        foreach($commands as $label){
            $command = $commandMap->getCommand($label);
            $command->setLabel($label . "_disabled");
            $command->unregister($commandMap);
        }
    }
}