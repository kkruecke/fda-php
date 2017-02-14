#!/usr/bin/env php
<?php

/*
 Removes control characters from the input file
 */

function prepare_file($file)
{
    $tr_cmd =  "tr -cd '\\11\\12\\15\\40-\\176' < " . '"' . $file . '"' . " | sponge ". '"'. $file . '"';

    // Remove control characters
    echo "Removing control characters from $file.\n";
 
    exec( $tr_cmd );
}

prepare_file($argv[1]);
