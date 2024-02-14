<?php

class TaskAttackPlayer extends TaskBase
{
	public $speedMultiplier;
	public $rangeSquared;
	
	public $attackCounter;
	
	public function __construct($speed, $range){
		$this->speedMultiplier = $speed;
		$this->rangeSquared = $range*$range;
	}
	
	public function onStart(EntityAI $ai)
	{
		$this->selfCounter = 1;
		console("found!");
	}
	
	
	public function onUpdate(EntityAI $ai)
	{
		if(!$this->isTargetValid($ai)){
			$this->reset();
			return false;
		}
		$ai->mobController->setMovingTarget($ai->entity->target->x, $ai->entity->target->y, $ai->entity->target->z, $this->speedMultiplier);
		$ai->mobController->setLookPosition($ai->entity->target->x, $ai->entity->target->y + 0.12, $ai->entity->target->z, 10, $ai->entity->getVerticalFaceSpeed());
		
		--$this->attackCounter;
		$mult = $ai->entity instanceof Spider ? 1 : 2;
		$v1 = $ai->entity->width * $ai->entity->width * $mult*$mult;
		
		$e = $ai->entity;
		$t = $e->target;
		$xDiff = ($t->x - $e->x);
		$yDiff = ($t->y - $e->y);
		$zDiff = ($t->z - $e->z);
		$dist = ($xDiff*$xDiff + $yDiff*$yDiff + $zDiff*$zDiff);
		if($dist <= $v1){
			if($this->attackCounter <= 0){
				$this->attackCounter = 20;
				
				$e->attackEntity($t);
				
			}
		}
		
	}
	
	
	public function isTargetValid(EntityAI $ai){
		$e = $ai->entity; //TODO sometimes it keeps being valid even after getting invalid (/gm 1 -> /gm 0 switch)
		if($e->target instanceof Entity){
			$t = $e->target;
			$xDiff = ($t->x - $e->x);
			$yDiff = ($t->y - $e->y);
			$zDiff = ($t->z - $e->z);
			return ($xDiff*$xDiff + $yDiff*$yDiff + $zDiff*$zDiff) <= $this->rangeSquared;
		}
		return false;
	}
	
	public function tryTargeting(EntityAI $ai){
		$e = $ai->entity;
		if($e->target instanceof Entity){
			$t = $e->target;
			$xDiff = ($t->x - $e->x);
			$yDiff = ($t->y - $e->y);
			$zDiff = ($t->z - $e->z);
			if(($xDiff*$xDiff + $yDiff*$yDiff + $zDiff*$zDiff) <= $this->rangeSquared){
				return true;
			}
		}
		$bestTargetDistance = INF;
		$closestTarget = null;
		foreach($e->level->players as $p){
			if($p->spawned){
				$pt = $p->entity;
				$xDiff = $pt->x - $e->x;
				$yDiff = $pt->y - $e->y;
				$zDiff = $pt->z - $e->z;
				$d = ($xDiff*$xDiff + $yDiff*$yDiff + $zDiff*$zDiff);
				if($d <= $this->rangeSquared){
					if($bestTargetDistance >= $d){
						$closestTarget = $pt;
						$bestTargetDistance = $d;
					}
				}
			}
		}
		
		if($closestTarget != null){
			$e->target = $closestTarget; //TODO dont save entity object ?
			return true;
		}
		return false;
	}
	
	public function canBeExecuted(EntityAI $ai)
	{
		return $this->tryTargeting($ai);
	}
	
	public function onEnd(EntityAI $ai)
    {
		
	}

}

