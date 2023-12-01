<?php

class DoubleTallGrass extends FlowableBlock
{
	public static $NAMES = [
		0 => "Sunflower",
		1 => "Lilac",
		2 => "Tall Grass",
		3 => "Tall Fern",
	];
	public function __construct($meta = 1){
		parent::__construct(DOUBLE_PLANT, $meta, "Tall Grass");
		$this->name = self::$NAMES[$this->meta];
		$this->hardness = 0;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){ //TODO destroy if 2nd block occupied
			if($this->getSide(0)->isTransparent === true){//Replace with common break method
				$this->level->setBlock($this, new AirBlock(), false, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){ //TODO vanilla?
		return [];
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() == 2 or $down->getID() == 3){ //TODO destroy the block above(tested only in creative)
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		}
		return false;
	}

}

