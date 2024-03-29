<?php
// run sql files
require_once 'config/connections.php';
require_once 'library/functions.php';

function resetDb()
{
    echo "\n:::Resetting db:::\n";
    $config = getConnConfig();

    // same config from docker
    $server = $config['server'];
    $dbname = $config['dbname'];
    $password = $config['password'];
    $username = $config['username'];

    $dsn = 'mysql:host=' . $server;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    // Create the actual connection object and assign it to a variable
    try {
        $link = new PDO($dsn, $username, $password, $options);

        // Create database
        $sql = "DROP DATABASE IF EXISTS " . $dbname . "; CREATE DATABASE " . $dbname;
        $link->exec($sql);
    } catch (PDOException $e) {
        echo $e;
        exit;
    }
}

function run_sql_file($location, $delimiter = ";")
{
    $db = acmeConnect();
    //load file
    $commands = file_get_contents($location);

    //delete comments
    $lines = explode("\n", $commands);
    $commands = '';
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line && !startsWith($line, '--')) {
            $commands .= $line . "\n";
        }
    }

    //convert to array
    $commands = explode($delimiter, $commands);

    //run commands
    $total = $success = 0;
    foreach ($commands as $command) {
        if (trim($command)) {
            echo "\nCOMMAND::::";
            echo $command;
            $success += ($db->exec($command) == false ? 0 : 1);
            $total += 1;
        }
    }

    //return number of successful queries and total number of queries found
    return array(
        "success" => $success,
        "total" => $total
    );
}

// Here's a startsWith function
function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function initSchema()
{
    echo "\n:::Initializing schema:::\n";

    $result = run_sql_file("sql/acme-db.sql", ";;");
    echo json_encode($result);
}

function initData()
{
    // run full file b/x there are queries using dynamic ids
    echo "\n:::Adding data:::\n";
    $db = acmeConnect();
    //load file
    $commands = file_get_contents("sql/acme-data.sql");

    try {
        $success = ($db->exec($commands) == false ? 0 : 1);

        echo json_encode($success);
    } catch (PDOException $e) {
        echo $e;
        exit;
    }
}

// resetDb();
initSchema();
initData();
