<?php 
namespace Maude;

/*
 * Only one instance of Configuration is ever created, as a local static within the static method self::getInstance()
 */

class Configuration {
    
    private static $database;  // SimpleXMLElement. Access members via -> syntax
    private static $files;     // SimpleXMLElement. Access members via -> syntax

    protected function __construct(string $filename)
    {
       $config = simplexml_load_file($filename);

       self::$database = $config->database;
       self::$files = $config->files;
    }

    public function getDatabaseParams() : \SimpleXMLElement
    {
	return self::$database;
    }

    public function getFiles() : \SimpleXMLElement
    {
	return self::$files;
    }

    protected function setInstance($filename) : Configuration
    {

       
    }

    getInstance()
    {
      static Configuration;

    protected static function init($filename) : void
    {
       static Configuration = new Configuration($filename);

    }

    public static function load($file_name)
    {
       self::init($file_name);
    }
}
