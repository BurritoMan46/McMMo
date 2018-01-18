<?php
/*
 * Made By BurritoMan46
 */
namespace src\Loader.php;
/* Essentials */
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\Player;
/* Execution */
use pocketmine\command\CommandExecutor;
use RTG\McMMO\CMD\Commands;
/* Event */
use pocketmine\event\player\PlayerJoinEvent;
class Loader extends PluginBase {
    
    public function onEnable() {
        /* Execution */
        $this->getCommand("mcmmo")->setExecutor(new Commands ($this));
        
        /* Configs */
        $this->minelevel = new Config($this->getDataFolder() . "minelevel.yml", Config::YAML);
        $this->alevel = new Config($this->getDataFolder() . "acrobaticlevel.yml", Config::YAML);
        $this->woodcuttinglevel = new Config($this->getDataFolder() . "woodcuttinglevel.yml", Config::YAML);
        $this->axelvl = new Config($this->getDataFolder() . "axelevel.yml", Config::YAML);
        $this->exalvl = new Config($this->getDataFolder() . "excavationlevel.yml", Config::YAML);
        $this->credits = new Config($this->getDataFolder() . "credits.yml", Config::YAML);
    }
    
    public function onGet($player) {
        $n = $player->getName();
        
        $this->minelevel->get(strtolower($n));
        $this->alevel->get(strtolower($n));
        $this->woodcuttinglevel->get(strtolower($n));
        $this->axelvl->get(strtolower($n));
        $this->exalvl->get(strtolower($n));
        $this->credits->get(strtolower($n));
            
    }
    
    public function onSave() {
        
        $this->minelevel->save();
        $this->alevel->save();
        $this->woodcuttinglevel->save();
        $this->axelvl->save();
        $this->exalvl->save();
        $this->credits->save();
        
    }
    
    public function onJoin(PlayerJoinEvent $e) {
        
        $p = $e->getPlayer();
        $n = $p->getName();
        $c = new Config($this->getDataFolder() . "credits.yml", Config::YAML);
        $g = $c->get(strtolower($n));
            if($g == "") {
                $c->set(strtolower($n), 0);
                $c->save();
            }
            
    }
    
    public function onDisable() {
    }
    
    
    
}
