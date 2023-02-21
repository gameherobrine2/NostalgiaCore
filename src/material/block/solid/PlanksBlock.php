<?php

class PlanksBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(PLANKS, $meta, "Wooden Planks");
		$names = array(
			WoodBlock::OAK => "Oak Wooden Planks",
			WoodBlock::SPRUCE => "Spruce Wooden Planks",
			WoodBlock::BIRCH => "Birch Wooden Planks",
			WoodBlock::JUNGLE => "Jungle Wooden Planks",
			WoodBlock::ACACIA => "Acacia Wooden Planks",
			WoodBlock::DARK_OAK => "Dark Oak Wooden Planks",
		);
		$this->name = $names[$this->meta & 0x03];
		$this->hardness = 15;
	}
	
}