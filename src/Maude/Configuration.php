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
       self::init($filename);
    }

    protected static function init(string $filename)
    {
       if (empty($filename))
               return;

       $config = simplexml_load_file($filename);

       self::$database = $config->database;
       self::$files = $config->files;
    }

    public function getDatabase() : \SimpleXMLElement
    {
	return self::$database;
    }

    public function getFiles() : \SimpleXMLElement
    {
        return self::$files;
    }

    public static function getConfiguration(string $file_name="") : Configuration
    {
      static $the_configuration;
      
        if (!isset($the_configuration) && !empty($file_name)) {
          
             $the_configuration = new Configuration($file_name);
        }
       
      return $the_configuration;
    }
}


