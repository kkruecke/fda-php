<?php
function prep_file($file)
{
    $parts = explode('.', $file);

    $clean_name = $parts[0] . "-clean" . ".$parts[1]";

    $tr_cmd =  "tr -cd '\\11\\12\\15\\40-\\176'" . "< " . $file . " > " . $clean_name;

    // 1. Remove control characters
    echo "Removing control characters.\n";
 
    exec( $tr_cmd );

    // Rename cleaned file to original file
    $rename = "mv $clean_name $file";

    exec ($rename);

    // 2. Do dos2unix
    echo "Doing dos2unix $file\n";

    $dos2unix_cmd = "dos2unix $file";

    echo "Removing first line header.\n";

    // 3. Remove first line of file
    $remove_1st =  "tail -n +2 $file | sponge $file";

    exec ($remove_1st); 

   // sort and remove duplicate lines
    $nodups_name = $parts[0] . "-nodups" . ".$parts[1]";

    $cmd_remove_dups =  "sort -t\"|\" -n -k 1 $file | uniq -u > $nodups_name";

    // 3. Do dos2unix
    echo "Removing duplicate lines.\n";

    exec($cmd_remove_dups);

    // Rename nodups file to original file
    $rename = "mv $nodups_name $file";

    exec ($rename);
}

$foitext_files = array("foitext1996.txt", "foitext1997.txt", "foitext1998.txt", "foitext1999.txt", "foitext2000.txt", "foitext2001.txt", "foitext2002.txt", "foitext2003.txt", 
     "foitext2004.txt", "foitext2005.txt", "foitext2006.txt", "foitext2007.txt", "foitext2008.txt", "foitext2009.txt", "foitext2010.txt", "foitext2011.txt", 
     "foitext2012.txt", "foitext2013.txt", "foitext2014.txt", "foitext2015.txt", "foitextAdd.txt", "foitext.txt"); 

   foreach($foitext_files as $x) {

      prep_file($x);      
   }

   echo "Concatenating all foitext files.\n";   

   // catenate all text files into one big files.
   $cmd_concat = "cat foitext*.txt >> foitext-all.txt";

   exec($cmd_concat);

   echo "\nfoitext-all.txt created.\n";
?>
