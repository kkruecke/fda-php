<?php
use PDO;

public function medwatch_update(PDO $pdo)
{
    
  $sql_insert = "INSERT into medwatch_report(:mdr_report_key, :text_report, :date_received, :report_source_code) values (?, ?, ?, ?)"; 
  
  $insert_stmt = $pdo->prepare($sql_insert); 

  $insert_stmt->bindParameter();
 
  $insert_stmt->bindParameter(); 

  $insert_stmt->bindParameter(); 

  $insert_stmt->bindParameter(); 

  $insert_stmt->bindParameter(); 
  
$sql_select = <<<SELECTDOC    
SELECT textfoi.mdr_report_key as mdr_report_key, textfoi.text_report as text_report, mdrfoi.date_received as date_received, mdrfoi.report_source_code as report_source_code
FROM textfoi 
INNER JOIN 
mdrfoi on textfoi.mdr_report_key=mdrfoi.mdr_report_key 
LEFT OUTER JOIN 
medwatch_report 
ON textfoi.mdr_report_key=medwatch_report.mdr_report_key 
WHERE medwatch_report.mdr_report_key IS NULL ORDER BY textfoi.mdr_report_key
SELECTDOC;
    
    $select_stmt->query($sql_select);    

    int insert_count = 0;

    while (result_set->next()) {
        
        /*
         *  Get the four results from the query as variables    
         *    mdr_report_key
         *    text_report
         *    date_received
         *    report_source_code
         */ 
        unsigned int mdr_report_key = result_set->getInt64(1);
        
        string text_report { result_set->getString(2) }; 
        
        string date_received { result_set->getString(3) };
        
        string report_source_code { result_set->getString(4) }; 
        
        insert_stmt->setInt64(1, mdr_report_key);    // change to assignParameter()    
        
        insert_stmt->setString(2, text_report);
        
        insert_stmt->setDateTime(3, date_received);
        
        insert_stmt->setString(4, report_source_code);
        
        insert_stmt->execute();
        
        ++insert_count;
        
        if (insert_count % 100 == 0) {
            
            cout << insert_count << " new records have been inserted into the medwatch_report table" << endl;
        }
    }
    
    // commit the transaction
    pdo.commit();

    return insert_count;
}
