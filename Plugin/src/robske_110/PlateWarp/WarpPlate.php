<?php
namespace robske_110\PlateWarp;

use pocketmine\Player;

/**
 * The object-ified PlateWarp
 */
class PlateWarp{
	private $assignedName;
	
    public function __construct($assignedName, $assignedBlock){
		
    }
	
    public function useFrom(Player $player){
		
    }

    /**
     * @return mixed
     */
    public function getAssignedName(): string{
        return $this->assignedName;
    }
}