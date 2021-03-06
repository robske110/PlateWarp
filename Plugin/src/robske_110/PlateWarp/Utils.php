<?php
/*
WARNING: THIS CLASS IS DISTRIBUTED UNDER GPLv3, NOT MIT!
*/
namespace robske_110\PlateWarp;

use pocketmine\Server;
use pocketmine\Player;

use robske_110\PlateWarp\PlateWarp;

abstract class Utils{
	#private static $server;
	private static $logger;
	private static $debugEnabled;
	private static $debugFile;
    
	const LOG_LVL_INFO = 0;
	const LOG_LVL_NOTICE = 1;
	const LOG_LVL_WARNING = 2;
	const LOG_LVL_CRITICAL = 3;
	const LOG_LVL_EMERGENCY = 4;
	const LOG_LVL_DEBUG = 5;
    
	const DEBUG_LVL_IMPORTED = 0;
	const DEBUG_LVL_NORMAL = 1;
	const DEBUG_LVL_PRIOR = 2;
    
	public static function init(PlateWarp $main, $debugEnabled = false){
		self::$logger = $main->getLogger();
		self::$debugEnabled = $debugEnabled;
		if($debugEnabled){
			$filename = $main->getDataFolder()."PlateWarpDebug".date("d:m:Y_H-i-s", time()).".txt";
			self::$debugFile = fopen($filename,'w+');
			if(!self::$debugFile){
				self::$debugEnabled = false;
				self::warning("Failed to create/open '".$filename."' for writing! Writing debug to file is disabled!");
			}
		}
	}
	public static function close(){
		if(self::$debugEnabled){
			fclose(self::$debugFile);
		}
	}
    
	public static function sendMsgToSender($sender, $msg){
		if($sender instanceof Player){
			$sender->getPlayer()->sendMessage(PLUGIN_MAIN_PREFIX.$message);
		}else{
			self::log($msg);
		}
	}
	private static function getTypeAsNameOfSender($sender){
		if($sender instanceof Player){
			$name = $sender->getPlayer()->getName();
		}else{
			$name = "CONSOLE";
		}
		return $name;
	}
	
	
	public static function log($msg, $logLvl = self::LOG_LVL_INFO){
		switch($logLvl){
			case self::LOG_LVL_INFO: self::$logger->info($msg); break;
			case self::LOG_LVL_NOTICE: self::$logger->notice($msg); break;
			case self::LOG_LVL_WARNING: self::$logger->warning($msg); break;
			case self::LOG_LVL_CRITICAL: self::$logger->critical($msg); break;
			case self::LOG_LVL_EMERGENCY: self::$logger->emergency($msg); break;
			case self::LOG_LVL_DEBUG: self::$logger->debug($msg); break;
		}
	}
    
	public static function notice($msg){
		self::log($msg, self::LOG_LVL_NOTICE);
		self::debug($msg, self::DEBUG_LVL_IMPORTED);
	}
	
	public static function warning($msg){
		self::log($msg, self::LOG_LVL_WARNING);
		self::debug($msg, self::DEBUG_LVL_IMPORTED);
	}
	public static function critical($msg){
		self::log($msg, self::LOG_LVL_CRITICAL);
		self::debug($msg, self::DEBUG_LVL_IMPORTED);
	}
	public static function emergency($msg){
		self::log($msg, self::LOG_LVL_EMERGENCY);
		self::debug($msg, self::DEBUG_LVL_IMPORTED);
	}
        
	public static function debug($msg, $debugLvl = self::DEBUG_LVL_NORMAL){
		if($debugLvl !== self::DEBUG_LVL_IMPORTED){
			self::log($msg, self::LOG_LVL_DEBUG);
		}
		if(self::$debugEnabled){
			switch($debugLvl){
				case self::DEBUG_LVL_IMPORTED: $msg = "[IMPORTED]> ".$msg." <"; break; //Imported debug msgs are imported from logger critical, warning and emergency msgs.
				case self::DEBUG_LVL_NORMAL: $msg = "[DEBUG]> ".$msg." <"; break;
				case self::DEBUG_LVL_PRIOR: $msg = "[IMPORTANT_DEBUG]!> ".$msg." <!"; break;
			}
			$msg .= "\n";
			fwrite(self::$debugFile, $msg);
		}
	}
}
//Theory is when you know something, but it doesn't work. Practice is when something works, but you don't know why. Programmers combine theory and practice: Nothing works and they don't know why!
//Just keep doing though. Just do it. Just keep working. Never give up.