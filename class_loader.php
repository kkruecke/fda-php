<?php
require_once("loader/SplClassLoader.php");

function boot_strap() 
{
//--date_default_timezone_set("America/Chicago"); // Workaround for PHP5 

 $spl_loader = new SplClassLoader('Maude', 'src');

 $spl_loader->register();

 $spl_loader2 = new SplClassLoader('Ds', 'vendor/php-ds/php-ds/src');

 $spl_loader2->register();

 // TODO: Set ini to include the current directory?

}
