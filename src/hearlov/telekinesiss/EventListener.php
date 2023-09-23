<?php

namespace hearlov\telekinesiss;

use pocketmine\block\BlockTypeIds;
use pocketmine\math\Vector3;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\event\Listener;
use pocketmine\scheduler\ClosureTask;

class EventListener implements Listener {

    private $plugin;
	
	public function __construct(Telekinesiss $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param BlockBreakEvent $event
     * @return void
     */
    public function onBreak(BlockBreakEvent $event): void
    {
        if ($event->isCancelled()) return;
        $drops = $event->getDrops();
        
        $telekinesissLevel = $event->getItem()->getEnchantmentLevel(EnchantmentIdMap::getInstance()->fromId(EnchantmentIds::TELEKINESISS));
        if ($telekinesissLevel == 0) return;
        $event->setDrops([]);

        $this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function() use ($event, $telekinesissLevel, $drops) : void{

            $pos = $event->getBlock()->getPosition();
            $wrld = $event->getPlayer()->getServer()->getWorldManager()->getWorldByName($pos->getWorld()->getFolderName());
            if($wrld->getBlock(new Vector3($pos->x, $pos->y, $pos->z), false, false)->getName() == $event->getBlock()->getName()) return;

            if ($telekinesissLevel >= 1) {
            
            foreach($drops as $item){
            if($event->getPlayer()->getInventory()->canAddItem($item)){
            $event->getPlayer()->getInventory()->addItem($item);
            }else{
            $pos->getWorld()->dropItem($pos->asVector3(), $item);
            }
            }

        }

		}), 1);

    }

    public function onHeld(PlayerItemHeldEvent $e){
        if ($e->isCancelled()) return;
        $telekinesissLevel = $e->getItem()->getEnchantmentLevel(EnchantmentIdMap::getInstance()->fromId(EnchantmentIds::TELEKINESISS));
        if($telekinesissLevel == 0) return;
        if(in_array("§cTelekinesiss I", $e->getItem()->getLore())) return;
        if(!isset($e->getItem()->getLore()[0])){
            $e->getPlayer()->getInventory()->setItem($e->getSlot(), $e->getItem()->setLore(["§cTelekinesiss I"]));
        }else{
            $newlore = $e->getItem()->getLore();
            array_unshift($newlore, "§cTelekinesiss I");
            $e->getPlayer()->getInventory()->setItem($e->getSlot(), $e->getItem()->setLore($newlore));
        }
    }

}