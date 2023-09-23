<?php

namespace hearlov\telekinesiss;

use pocketmine\item\enchantment\StringToEnchantmentParser;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\plugin\PluginBase;

class Telekinesiss extends PluginBase {

    protected function onEnable(): void{
        $enchantIdMap = EnchantmentIdMap::getInstance();
        $enchantParser = StringToEnchantmentParser::getInstance();
        $enchantIdMap->register(EnchantmentIds::TELEKINESISS, EnchantIds::TELEKINESISS());
        $enchantParser->register("telekinesiss", fn() => EnchantIds::TELEKINESISS());

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
}