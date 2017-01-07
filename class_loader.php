<?php
require_once("loader/SplClassLoader.php");

function boot_strap() 
{
 $spl_loader = new SplClassLoader('Maude', 'src');

 $spl_loader->register();
/*
 $spl_loader2 = new SplClassLoader('Ds', 'vendor/php-ds/php-ds/src');

 $spl_loader2->register();
 */
}
