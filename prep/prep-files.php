<?php

require_once "maude-arrays.php";

function prep_file($file)
{
    $parts = explode('.', $file);

    $clean_name = $parts[0] . "-clean" . ".$parts[1]";

    $tr_cmd =  "tr -cd '\\11\\12\\15\\40-\\176'" . "< " . $file . " > " . $clean_name;

    // 1. Remove control characters
    echo "Removing control characters from $file.\n";
 
    exec( $tr_cmd );

    // Rename cleaned file to original file
    $rename = "mv $clean_name $file";

    exec ($rename);

    // 2. Do dos2unix
    echo "Doing dos2unix $file\n";

    $dos2unix_cmd = "dos2unix $file";

    echo "Removing first line header from $file.\n";

    // 3. Remove first line of file
    $remove_1st =  "tail -n +2 $file | sponge $file";

    exec ($remove_1st); 

   // sort and remove duplicate lines
    $nodups_name = $parts[0] . "-nodups" . ".$parts[1]";

    $cmd_remove_dups =  "sort -t\"|\" -n -k 1 $file | uniq -u > $nodups_name";

    // 3. Do dos2unix
    echo "Removing duplicate lines from $file.\n";

    exec($cmd_remove_dups);

    // Rename nodups file to original file
    $rename = "mv $nodups_name $file";

    exec ($rename);
}

function concat_all($input_file_mask, $output_file)
{
   echo "Concatenating $input_file_mask\n";   

   // catenate all text files into one big files.
   $cmd_concat = "cat $input_file_mask >> $output_file"; //foitext*.txt >> foitext-all.txt";

   exec($cmd_concat);

   echo "\n$output_file created.\n";

}

 foreach($arrays as $current_array) {

   foreach($current_array as $file) {

      prep_file($file);      
   }
 }

   concat_all("foidev*.txt", "foidev-all.txt");
   concat_all("mdrfoi*.txt", "mdrfoi-all.txt");
   concat_all("foitext*.txt", "foitext-all.txt");
?>
