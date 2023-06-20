<?php 


    
function createBackupFilename($db, $prefix) {
    $names = [
        ['Emily', 'Sophia', 'Amelia', 'Harper', 'Evelyn', 'Abigail', 'Ella', 'Ava', 'Sophie', 'Isabella'],
        ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor']
    ];
$firstName = $names[0][array_rand($names[0])];
$lastName = $names[1][array_rand($names[1])];
$randomCode = rand(1000, 9999);
$timestamp = date('Y-m-d_H-i-s');
$filename = "{$firstName}_{$lastName}_{$randomCode}_{$timestamp}.sql";
return $filename;
}

 function createDatabaseBackupAndPrefix($db, $prefix, $backupFilename) {
    $tables = [];
    $result = $db->query("SHOW TABLES");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }

    $createTableQueries = '';
    $insertIntoTableQueries = '';

    foreach ($tables as $table) {
        $result = $db->query("SELECT * FROM $table");
        $numFields = $result->columnCount();
    
        $createTableQueries .= "DROP TABLE IF EXISTS $table;";
        $row2 = $db->query("SHOW CREATE TABLE $table")->fetch(PDO::FETCH_NUM);
        $createTableQueries .= "\n\n" . $row2[1] . ";\n\n";
    
        for ($i = 0; $i < $numFields; $i++) {
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $insertIntoTableQueries .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $numFields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
                    if (isset($row[$j]) && $row[$j] !== '') { // check if the value is not empty
                        $insertIntoTableQueries .= '"' . $row[$j] . '"';
                    } else {
                        $insertIntoTableQueries .= 'NULL'; // if the value is empty, insert NULL
                    }
                    if ($j < ($numFields - 1)) {
                        $insertIntoTableQueries .= ',';
                    }
                }
                $insertIntoTableQueries .= ");\n";
            }
        }
        $insertIntoTableQueries .= "\n\n\n";
    }    

    $backupFolder = 'backups/';
    if (!is_dir($backupFolder)) {
        mkdir($backupFolder, 0777, true);
    }

    // Add SET FOREIGN_KEY_CHECKS statements to the backup file content
    $backupFileContent = "SET FOREIGN_KEY_CHECKS=0;\n\n" . $createTableQueries . $insertIntoTableQueries . "\n\nSET FOREIGN_KEY_CHECKS=1;";

    $backupFilepath = $backupFolder . $backupFilename;
    if (file_put_contents($backupFilepath, $backupFileContent)) {
        return true;
    } else {
        return false;
    }
}
 

 function createDatabaseBackup($db, $prefix, $backupFilename) {
    $tables = [];
    $result = $db->query("SHOW TABLES");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }

    $createTableQueries = '';
    $insertIntoTableQueries = '';

    foreach ($tables as $table) {
        $originalTable = $table;  // Keep original table name
        $table = str_replace($prefix['table_prefix'] . '_', '', $table);  // Remove prefix

        $result = $db->query("SELECT * FROM $originalTable");
        $numFields = $result->columnCount();
    
        $createTableQueries .= "DROP TABLE IF EXISTS $table;";
        $row2 = $db->query("SHOW CREATE TABLE $originalTable")->fetch(PDO::FETCH_NUM);
        $createTableStatement = $row2[1];
        // Remove prefix from the create table statement
        $createTableStatement = preg_replace("/`".$prefix['table_prefix']."_(.*?)`/", "`$1`", $createTableStatement);
        $createTableQueries .= "\n\n" . $createTableStatement . ";\n\n";
    
        for ($i = 0; $i < $numFields; $i++) {
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $insertIntoTableQueries .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $numFields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
                    if (isset($row[$j]) && $row[$j] !== '') { // check if the value is not empty
                        $insertIntoTableQueries .= '"' . $row[$j] . '"';
                    } else {
                        $insertIntoTableQueries .= 'NULL'; // if the value is empty, insert NULL
                    }
                    if ($j < ($numFields - 1)) {
                        $insertIntoTableQueries .= ',';
                    }
                }
                $insertIntoTableQueries .= ");\n";
            }
        }
        $insertIntoTableQueries .= "\n\n\n";
    }    

    $backupFolder = 'backups/';
    if (!is_dir($backupFolder)) {
        mkdir($backupFolder, 0777, true);
    }

    // Add SET FOREIGN_KEY_CHECKS statements to the backup file content
    $backupFileContent = "SET FOREIGN_KEY_CHECKS=0;\n\n" . $createTableQueries . $insertIntoTableQueries . "\n\nSET FOREIGN_KEY_CHECKS=1;";

    $backupFilepath = $backupFolder . $backupFilename;
    if (file_put_contents($backupFilepath, $backupFileContent)) {
        return true;
    } else {
        return false;
    }
}






function getBackupFilesList($backupDir) {
    $files = array_diff(scandir($backupDir), array('..', '.'));
    $backupFiles = [];
    foreach ($files as $file) {
        if (is_file($backupDir . $file)) {
            $backupFiles[] = $file;
        }
    }
    usort($backupFiles, function($a, $b) use ($backupDir) {
        return filemtime($backupDir . $b) - filemtime($backupDir . $a);
    });

    return $backupFiles;
}
