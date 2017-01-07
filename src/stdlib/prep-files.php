<?php

require_once "maude-arrays.php";
/* 
1. Removes control characters
2. Converts from dos to unix
3. Removes first line column header
 */

function prepare_file($tmp_ext, $file)
{
    $tmp = $file . $tmp_ext;

    echo "Creating temp file $tmp\n";

    exec( "cp $file $tmp");

    $tr_cmd =  "tr -cd '\\11\\12\\15\\40-\\176'" . "< " . $tmp . " | sponge $tmp";

    // 1. Remove control characters
    echo "Removing control characters from $tmp.\n";
 
    exec( $tr_cmd );

    // 2. Do dos2unix
    echo "Doing dos2unix $tmp\n";

    $dos2unix_cmd = "dos2unix $tmp";

    echo "Removing first line header from $tmp.\n";

    // 3. Remove first line of file
    $remove_1st =  "tail -n +2 $tmp | sponge $tmp";

    exec ($remove_1st); 
}

function remove_duplicates($file)
{
    // sort $file
    $cmd_sort =  "sort -t\"|\" -n -k 1 $file | sponge $file";

    exec($cmd_sort);

    // Remove duplicates
    $cmd_remove_dups =  "uniq -u $file | sponge $file";

    echo "Removing duplicate lines from $file.\n";

    exec($cmd_remove_dups);
}

function concatenate($in, $out)
{
   echo "Doing: cat $in >> $out\n";

   // catenate all text files into one big files.
   $cmd_concat = "cat $in >> $out"; //foitext*.txt >> foitext-all.txt";

   exec($cmd_concat);

   echo "\n$out created.\n";
}

 $tmp_ext = ".tmp"; // The working files will be new files, ending in .tmp, and the original files will be untouched.
  
 foreach($arrays as $current_array) {

   foreach($current_array as $file) {

      prepare_file($tmp_ext, $file);      
   }
 }
 
 $array = array("foidev*.txt" => "foidev-all.txt",  "mdrfoi*.txt" => "mdrfoi-all.txt" , "foitext*.txt" => "foitext-all.txt");

 foreach($array as $infile_mask => $outfile) {

    concatenate($infile_mask . $tmp_ext, $outfile);

    remove_duplicates($outfile);
 }
