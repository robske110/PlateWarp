<?php
namespace robske_110\PlateWarp\api;


use robske_110\PlateWarp\PlateWarp;

/**
 * This class provides an API for interacting with
 * PlateWarp, whenever possible, use methods from this
 * class instead of elsewhere.
 */
class PlateWarpAPI {
    private $plugin;
	
    public function __construct(PlateWarp $main){
        $this->plugin = $main;
    }
	
    public function getPlateWarp(): PlateWarp{
        return $this->plugin;
    }
	
    public function getWarpManager(): WarpManager{
        return $this->plugin->getWarpManager();
    }
	
    /**
     * @deprecated
     * @param PluginBase $base (Usually your plugin Main class!)
     */
    public static function getInstance(PluginBase $plugin): PlateWarpAPI{
        return $plugin->getServer()->getPluginManager()->getPlugin("PlateWarp")->getApi();
    }
}