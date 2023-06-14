<?php 


    
function createBackupFilename($db) {
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

function createDatabaseBackup($db, $backupFilename) {
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
                if (isset($row[$j])) {
                    $insertIntoTableQueries .= '"' . $row[$j] . '"';
                } else {
                    $insertIntoTableQueries .= '""';
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

$backupFileContent = $createTableQueries . $insertIntoTableQueries;
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
