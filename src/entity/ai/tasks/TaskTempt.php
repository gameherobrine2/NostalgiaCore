<?php

class TaskTempt extends TaskBase
{
	public $target = false;
	
	public function onStart(EntityAI $ai)
	{
		$this->selfCounter = 1;
	}

	public function onEnd(EntityAI $ai)
	{
		unset($this->target);
		$ai->entity->pitch = 0;
	}

	public function onUpdate(EntityAI $ai)
	{
		if($this->target instanceof Entity && $this->target->distanceSquared($ai->entity) > 100 || !$ai->entity->isFood($this->target->player->getHeldItem()->getID())){
			$this->reset();
			return;
		}
		//TODO following
		$ai->mobController->lookOn($this->target);
		$pk = new RotateHeadPacket(); //TODO headYaw auto update
		$pk->eid = $ai->entity->eid;
		$pk->yaw = $ai->entity->yaw;
		$ai->entity->server->api->player->broadcastPacket($ai->entity->level->players, $pk);
	}

	public function canBeExecuted(EntityAI $ai)
	{
		if(!($ai->entity instanceof Breedable)){
			return false;
		}
		$target = $this->findTarget($ai->entity, 10);
		if($target instanceof Entity && $target->class === ENTITY_PLAYER && $target->isPlayer() && $ai->entity->isFood($target->player->getHeldItem()->getID())){
			$this->target = $target;
			return true;
		}
		
		return false;
	}
	
	protected function findTarget($e, $r){
		$svd = null;
		$svdDist = -1;
		foreach($e->server->api->entity->getRadius($e, $r * 3, ENTITY_PLAYER) as $p){
			if($svdDist === -1){
				$svdDist = Utils::manh_distance($e, $p);
				$svd = $p;
				continue;
			}
			if($svd != null && $svdDist === 0){
				$svd = $p;
			}
			
			if(($cd = Utils::manh_distance($e, $p)) < $svdDist){
				$svdDist = $cd;
				$svd = $p;
			}
		}
		
		if($svd == null || Utils::distance_noroot($e, $svd) > ($r * $r)){
			return null;
		}
		
		return $svd;
	}
}

