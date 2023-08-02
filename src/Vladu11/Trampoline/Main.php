<?php

namespace Vladu11\Trampoline;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\world\World;
use pocketmine\world\Position;
use pocketmine\world\particle\Particle;
use pocketmine\world\particle\HappyVillagerParticle;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;
use pocketmine\Player;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\block\Block;

class Main extends PluginBase implements Listener {
	private $config;
	
	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents($this ,$this);
		$this->saveDefaultConfig();
		$this->config = $this->getConfig();
		$this->getLogger()->info("Enabled!");
	}
	
	public function onMove(PlayerMoveEvent $event){
		$player = $event->getPlayer();
		$pos = $player->getPosition();
		$x = $pos->getX();
		$y = $pos->getY();
		$z = $pos->getZ();
		$world = $player->getWorld();
		$block = $world->getBlock($pos->getSide(0));
		if(strtolower(str_replace(" ", "_", $block->getName())) == $this->config->get('Block')){
			$direction = $player->getDirectionVector();
			$dx = $direction->getX();
			$dz = $direction->getZ();
			$dy = $direction->getY();
			if($this->config->get("Particle") == "true"){
				$world->addParticle(new Vector3($x - 0.3, $y, $z), new HappyVillagerParticle);
                                $world->addParticle(new Vector3($x, $y, $z - 0.3), new HappyVillagerParticle);
                                $world->addParticle(new Vector3($x + 0.3, $y, $z), new HappyVillagerParticle);
                                $world->addParticle(new Vector3($x, $y, $z + 0.3), new HappyVillagerParticle);
                           }
			$player->setMotion(new Vector3(0, $this->config->get('Power'), 0));
		}
	}
	public function onDisable() : void {
		$this->getLogger()->info(C::DARK_RED."Disabled!");
	}
}
