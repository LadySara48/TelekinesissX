<?php

namespace hearlov\telekinesiss;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\ItemFlags;
use pocketmine\item\enchantment\Rarity;
use pocketmine\utils\RegistryTrait;

/**
 * @method static Enchantment TELEKINESISS()
 */
class EnchantIds {
    use RegistryTrait;

    /**
     * @return void
     */
    protected static function setup(): void {
        self::_registryRegister("TELEKINESISS", new Enchantment("Telekinesiss", Rarity::RARE, ItemFlags::DIG, ItemFlags::NONE, 1));
    }
}