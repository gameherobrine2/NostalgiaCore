<?php

class CarpetBlock extends FlowableBlock{
	
	protected static $names = [0 => "White Carpet",
		1 => "Orange Carpet",
		2 => "Magenta Carpet",
		3 => "Light Blue Carpet",
		4 => "Yellow Carpet",
		5 => "Lime Carpet",
		6 => "Pink Carpet",
		7 => "Gray Carpet",
		8 => "Light Gray Carpet",
		9 => "Cyan Carpet",
		10 => "Purple Carpet",
		11 => "Blue Carpet",
		12 => "Brown Carpet",
		13 => "Green Carpet",
		14 => "Red Carpet",
		15 => "Black Carpet",];
	
	public function __construct($meta = 0){
		parent::__construct(CARPET, $meta, self::$names[$meta]);
		$this->hardness = 0;
		$this->isFullBlock = false;		
		$this->isSolid = true;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() !== AIR){
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		}
		return false;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getID() === AIR){ //Replace with common break method
				ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem($this->id, $this->meta, 1));
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
}