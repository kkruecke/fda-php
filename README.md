LASIK Maude Data Extraction code
================================

Ds Data Structures for PHP Extension Dependency
-----------------------------------------------

The code uses the PHP ds extension described at http://php.net/manual/en/ds.installation.php and https://github.com/php-ds/extension/blob/master/README.md.

Note: To enable the extension on Ubuntu or Linux Mint, create the following file /etc/php/7.0/mods-available/ds.ini wit the contents of

    ; configuration for php ds module
    ; priority=30
    extension=ds.so 

Then do (on Linux Mint and Ubuntu):

    $ sudo phpenmod ds

Without doing this first, you will get: unable to load '/usr/lib/..../ds.so' undefined symbol json....'

Comments
--------

The **medwatch** database contains all the lasik adverse event reports since 1998. Its single medwatch\_report table was built from joining data from the three tables
in the maude database.  To update the maude database, run 

    php -f main.php 

The code is driven by the config.xml file, which will described in a later update.

TODO: Descrobe config.xml here

A single input file for Text, Device, etc should contain the latest or prospective lastest data. To create this file:

1. Concatenate the .txt files into one file
2. Sort it by the first key, the mdr\_report\_key
3. Remove duplicate lines

For example, below we concatenate to foixtextXXX.txt files, sort it by the first field, the mdr\_report\_key, then remove duplicates:

    $ cat foitext2015.txt >> foitext.txt
    $ sort -t'|' -k1 foitext.txt | uniq > foitext-nodups.txt
    $ mv foitext-nodups.txt foitext.txt 
