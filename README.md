LASIK Maude Data Extraction code
================================

Ds Data Structures for PHP Extension Dependency
-----------------------------------------------

The code uses the PHP **Ds** data structures extension. See [How to install Ds for PHP](https://github.com/php-ds/extension/blob/master/README.md).

After I installed **Ds** on **Linux Mint**, I edited /etc/php/7.0/mods-available/ds.ini to be

> ; configuration for php ds module
> ; priority=30
>   extension=ds.so 

before enabling it (on Linux Mint and Ubuntu): `$ sudo phpenmod ds`. Without editin ds.ini first, you will get: 

> unable to load '/usr/lib/..../ds.so' undefined symbol json....'

It is also recommended to install a compatilbility polyfill 

> composer require php-ds/php-ds    

Comments
--------

The **medwatch** database contains all the lasik adverse event reports since 1998. Its single medwatch\_report table was built from joining data
from the three tables in the Maude database.  To extract the LASIK data from the Maude foi .txt files and insert it into the medwatch database, run 

    php -f main.php 

The code is driven by the **config.xml file**, which is self explanatory. To create the .txt input files for the PHP code, you must create a single input 
.txt file for foitext (Text), foidev (Device), and Mdr that contains the latest [FDA Maude Free of Information .txt files](http://www.fda.gov/MedicalDevices/DeviceRegulationandGuidance/PostmarketRequirements/ReportingAdverseEvents/ucm127891.htm).
After downloading the respective .txt files:

1. Concatenate each categories--text, device or mdr--.txt files into one big .txt file
2. Sort it by the first key, the mdr\_report\_key
3. Remove duplicate lines.

This can be done using the Linux command line. For example, below we concatenate to foixtextXXX.txt files, sort it by the first field, the mdr\_report\_key,
then remove duplicates:

    $ dos2unix *.txt
    $ cat foitext2015.txt >> foitext.txt
    $ sort -t'|' -k1 foitext.txt | uniq > foitext-nodups.txt
    $ mv foitext-nodups.txt foitext.txt 

Next edit the **confg.xml** file as needed with the correct .txt file name. The only other settings in config.xml that need to be customized are the database
settings. 

See howto.txt for more details.
