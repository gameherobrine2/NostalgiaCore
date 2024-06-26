<?php

class CactusBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(CACTUS, $meta, "Cactus");
		$this->isFullBlock = false;
		$this->hardness = 2;
	}
	
	public static function onEntityCollidedWithBlock(Level $level, $x, $y, $z, Entity $entity){
		$entity->harm(1, "cactus");
	}
	public static function getCollisionBoundingBoxes(Level $level, $x, $y, $z, Entity $entity){
		return [new AxisAlignedBB($x + 0.0625, $y, $z + 0.0625, $x - 0.0625, $y - 0.0625, $z - 0.0625)];
	}
	
	public static function onRandomTick(Level $level, $x, $y, $z){
		//$b = $level->level->getBlock($x, $y - 1, $z);
		$underID = $level->level->getBlockID($x, $y - 1, $z);
		$b = $level->level->getBlock($x, $y, $z);
		$id = $b[0];
		$meta = $b[1];
		if($underID !== CACTUS){
			if($meta == 0x0F){
				for($yy = 1; $yy < 3; ++$yy){
					$bID = $level->level->getBlockID($x, $y + $yy, $z);
					if($bID === AIR){
						$level->fastSetBlockUpdate($x, $y + $yy, $z, CACTUS, 0);
						$level->getBlockWithoutVector($x, $y + $yy, $z)->onUpdate(BLOCK_UPDATE_NORMAL); //TODO rewrite ticking
						break;
					}
				}
				$meta = 0;
				$level->fastSetBlockUpdate($x, $y, $z, $id, $meta);
			}else{
				$level->fastSetBlockUpdate($x, $y, $z, $id, $meta + 1);
			}
			return BLOCK_UPDATE_RANDOM;
		}
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			$down = $this->getSide(0);
			$block0 = $this->getSide(2); 
			$block1 = $this->getSide(3);
			$block2 = $this->getSide(4);
			$block3 = $this->getSide(5);
			if($block0->isFlowable === false or $block1->isFlowable === false or $block2->isFlowable === false or $block3->isFlowable === false or ($down->getID() !== SAND and $down->getID() !== CACTUS)){ //Replace with common break method
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem($this->id));
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() === SAND or $down->getID() === CACTUS){
			$block0 = $this->getSide(2);
			$block1 = $this->getSide(3);
			$block2 = $this->getSide(4);
			$block3 = $this->getSide(5);
			if($block0->isFlowable === true and $block1->isFlowable === true and $block2->isFlowable === true and $block3->isFlowable === true){
				$this->level->setBlock($this, $this, true, false, true);
				$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
				ServerAPI::request()->api->block->scheduleBlockUpdate(clone $this, 10, BLOCK_UPDATE_NORMAL);
				return true;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}
}