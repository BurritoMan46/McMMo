<?php
namespace src\CMD;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;
use RTG\McMMO\Loader;
/**
 * Description of Commands
 *
 * @author RTG
 */
class Commands implements CommandExecutor {
    
    public function __construct(Loader $main) {
        $this->main = $main;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $param) {
        switch(strtolower($cmd->getName())) {
            
            case "mcmmo":
                if($sender->hasPermission("mcmmo.command")) {
                    if(isset($param[0])) {
                        
                        switch(strtolower($param[0])) {
                            
                            case "stats":
                                
                                $sender->sendMessage("-- Your Stats --");
                                $this->main->onGet($sender);
                                
                                return true;
                            break;
                            
                            case "about":
                                
                                $msg = [
                                    "[MCMMO] Author: BlindSalvas ",
                                    "[MCMMO] Made by Twitter : @TastySandwicy"
                                ];
                                
                                $sender->sendMessage(implode(" ", $msg));
                                
                                return true;
                            break;
                            
                            case "help":
                                
                                $msg = [
                                    "[MCMMO] /mcmmo stats - Gets your stats!",
                                    "[MCMMO] /mcmmo about - Gets about the author of this plugin",
                                    "[MCMMO] /mcmmo credits - Gets your or other player's credits!",
                                    "[MCMMO] /mcmmo addcredits - Add Credits to a player"
                                ];
                                
                                $sender->sendMessage(implode(" ", $msg));
                                
                                return true;
                            break;
                            
                            case "credits":
                                
                                    $c = new Config($this->main->getDataFolder() . "credits.yml", Config::YAML);
                                    $n = $sender->getName();
                                    $cr = $c->get(strtolower($n));
                                    $sender->sendMessage("[MCMMO] You have $cr credits!");
                                
                                return true;
                            break;
                            
                            case "addcredits":
                                
                                if($sender->hasPermission("mcmmo.addcredits")) {
                                
                                    if(isset($param[1])) {
                                    
                                        $c = new Config($this->main->getDataFolder() . "credits.yml", Config::YAML);
                                        $n = $param[1];
                                        
                                        if(isset($param[2])) {
                                        
                                            $amt = $param[2];
                                            
                                                $g = $c->get(strtolower($n));
                                                $c->set(strtolower($n), $g + $amt);
                                                $c->save();
                                                $sender->sendMessage("[MCMMO] You have successfully added $amt to $n!");
                                           
                                        }
                                        else {
                                            $sender->sendMessage("[MCMMO] /mcmmo addcredits [username] [amount]");
                                        }
                                        
                                    }
                                    else {
                                        $sender->sendMessage("[MCMMO] /mcmmo addcredits [username] [amount]");
                                    }
                                
                                }
                                else {
                                    $sender->sendMessage(TF::RED . "You have no permission to use this command!");
                                }
                                    
                                return true;
                            break;
                            
                            case "reducecredits":
                                
                                if($sender->hasPermission("mcmmo.reducecredits")) {
                                    
                                    if(isset($param[1])) {
                                        
                                        if(isset($param[2])) {
                                            
                                            $n = $param[1];
                                            $amt = $param[2];
                                            
                                                $c = new Config($this->main->getDataFolder() . "credits.yml", Config::YAML);
                                                
                                                $g = $c->get(strtolower($n));
                                                $c->set(strtolower($n), $g - $amt);
                                                $c->save();
                                                $sender->sendMessage("[MCMMO] You have successfully reduced $amt credits from $n!");
                                               
                                        }
                                        else {
                                            $sender->sendMessage("[MCMMO] /mcmmo reducecredits [username] [amount]");
                                        }
                                             
                                    }
                                    else {
                                        $sender->sendMessage("[MCMMO] /mcmmo reducecredits [username] [amount]");
                                    }
                                      
                                }
                                else {
                                    $sender->sendMessage(TF::RED . "You have no permission to use this command!");
                                }
                                
                                return true;
                            break;
                            
                            case "test":
                                
                                $c = new Config($this->main->getDataFolder() . "credits.yml", Config::YAML);
                                $c->set(strtolower($sender->getName(), 0));
                                    if($c->get(strtolower($sender->getName())) == "") {
                                        $c->set(strtolower($sender->getName()), 0);
                                        $c->save();
                                    }
                                
                                return true;
                            break;
                               
                        }
                          
                    }
                    else {
                        $sender->sendMessage("[MCMMO] /mcmmo help");
                    }
                       
                }
                else {
                    $sender->sendMessage(TF::RED . "You have no permission to use command!");
                }
                
                return true;
            break;
               
        }
           
    }
   
}
