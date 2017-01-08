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

The code is driven by the **config.xml file**, which is self explanatory.

Overview
--------

1. The common field link between the device file, the mdrfoi file, and text file is Mdr Report Key

2. From the Device File you need fields
   \#1 - MDR Report Key
  \#26 - Device Report Product Codes for codes of "HNO" or "LZS" (those are the laser product codes)

3. From the MDRFOI File, you need fields:
   \#1 MDR Report Key,
   \#4 - Report Source Code (i.e. patient reports are typically "P"-voluntary reports) and
  \#12 - Date of Event (from the date of event, you'll ultimately get the file year)

4. From the Text File, you need field #1 MDR Report Key and field #6 Text

The steps I've used in the past are as follows:

1. Relate the tables on the common field Mdr Report Key to bring in the required fields from the 3 tables.
2. Remove all device report product codes not equal to HNO or LZS
3. Create a File Year based on the #12-Date of Event
4. The \#3 AE notes from the output file above is a manual process after export of the FDA MAUDE files and reading the text to categorize whether each filing
   is for dry eyes, NVD, ectasia, etc.

Programmatic Perspective
------------------------

 From foidev file we extract these fields:

   \#1. MDR report key
  \#26. Device Report Product Code equal to "HNO" or "LZS". These are the laser product codes.

I just take the first HNO or LZS record found. Save this in foi_device.

 From the mdrfoi file take these fields

   \#1. MDR report key
   \#4. Report Source Code
  \#12. Date of Event

 save this in mdr_foi. Eliminate duplicate rows from it.
 
 From the foitext file take

   \#1. MDR Report Key
   \#6. Text

save this in foi_text.

Steps I Use
-----------

1. Manually create a copy of the up-to-date medwatch database. Leave the original as a backup. We will insert all new lasik reports into the new copy.

2. Use maude.sql to create temporary tables to hold the new lasik records that we find in maude .txt files

    - foidevice
    - foimdr
    - foitext

    CREATE TABLE IF NOT EXISTS devicefoi (
      mdr_report_key bigint NOT NULL,
      device_product_code CHAR(3) NOT NULL, 
      PRIMARY KEY (mdr_report_key)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
    
    CREATE TABLE IF NOT EXISTS mdrfoi (
      id int(11) NOT NULL AUTO_INCREMENT,
      mdr_report_key bigint NOT NULL,
      report_source_code char(1) NOT NULL,
      date_received date NOT NULL,
      PRIMARY KEY (id),
      UNIQUE KEY(mdr_report_key),
      FOREIGN KEY (mdr_report_key) REFERENCES devicefoi(mdr_report_key) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
    
    CREATE TABLE IF NOT EXISTS textfoi (
      id int(11) NOT NULL AUTO_INCREMENT,
      mdr_report_key bigint NOT NULL,
      text_report longtext NOT NULL,
      PRIMARY KEY (id),
      UNIQUE KEY(mdr_report_key),
      FOREIGN KEY (mdr_report_key) REFERENCES devicefoi(mdr_report_key) ON DELETE CASCADE
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
        
3. To prepare the maude .txt files
    
   Edit src/stdlib/maude-arrays.php, which is self explanatory. Copy from src/stdib/, maude-arrays.php and prep-files.php ./data, cd to data, and then run

       php -f  prep-files.php

   See internals of prep-files.php for an explanation of what it does.
    
4. If the above .txt files contain a lot of old data that already exists in the medwatch table, we can be be manually remove this redundant data by
    
        1. First determing the max(medwatch.mdr_report_key) in the current medwatch table.
    
          $ mysql -u root -p -D maude_whatever
          $ select max(mdr_report_key) as max from medwatch_report;
    
        2. Then delete those row whose MDR REPORT KEY is less than this max value by running ./rewrite.php, after first setting the $max_mdr_report_key 
           variable in rewrite.php.

        3. Copy the newly written .new files over the existing *-all.txt files.
       
5. Change the xml-config.xml so that it contains the correctly named files in ./data
  
6. Run php -f main.php  

Inset on Parsing
~~~~~~~~~~~~~~~~
    
The parsing of each file works like this:

1. Parses foidev.txt looking for Device Product Codes equal to "HNO" or "LSZ", excimer lasik or microkeratome records. Compares the MDR Report Key's of this row
   with the max(mdr\_report\_key) from the medwatch\_report table. Writes the MDR Report Key and Device Product Code to the foidevice table if its MDR Report Key
   is greater than the max found above. 

2. Parses mdrfoi.txt file extracting the fields

   1.) MDR Report Key
   2.) Report Source Code (i.e. patient reports are typically "P"-voluntary reports)
   3.) Date of Event. 

   If the MDR Report Key was inserted in step #3 and therefore exists in the foidevice.txt table, save these three fields to the mdrfoi table.

3. Parse the foitext.txt file and extract the MDR Report Key and Text Report fields. Again, if the MDR Report Key is in the foidevice table (as well as the mdrfoi
   table), write these two fields to the foitext table, checking first that they have not already been inserted.

5. Join the results of these three tables and insert the result into the medwatch\_report table.

6. The temporary devicefoi, mdrfoi and textfoi tables can now be deleted.
