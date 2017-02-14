<?php
include "SplClassLoader.php";

 $spl_loader = new SplClassLoader('Maude', 'src');

 $spl_loader->register();
