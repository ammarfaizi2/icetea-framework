<?php

namespace Console\Commands;

use mysqli;
use System\Crayner\Contracts\Console\Command;
use System\Crayner\ConfigHandler\Configer;
use Console\Exception\InvalidArgumentException;

class Import implements Command
{
    public function prepare($selection, $optional, $command)
    {
    }

    public function argument($argument)
    {
    }

    public function showResult()
    {
    }

    public function execute()
    {
        error_reporting(0);
        $conf = Configer::database();
        $host = $conf['host'];
        $user = $conf['user'];
        $pass = $conf['pass'];
        $dbname = $conf['dbname'];
        $sql_file_OR_content = file_get_contents(BASEPATH."/database.sql");
        set_time_limit(3000);
        $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ?  $sql_file_OR_content : file_get_contents($sql_file_OR_content));
        $allLines = explode("\n", $SQL_CONTENT);
        $mysqli = new mysqli($host, $user, $pass, $dbname);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $zzzzzz = $mysqli->query('SET foreign_key_checks = 0');
        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n". $SQL_CONTENT, $target_tables);
        foreach ($target_tables[2] as $table) {
            $mysqli->query('DROP TABLE IF EXISTS '.$table);
        }
        $zzzzzz = $mysqli->query('SET foreign_key_checks = 1');
        $mysqli->query("SET NAMES 'utf8'");
        $templine = '';
        foreach ($allLines as $line) {
            if (substr($line, 0, 2) != '--' && $line != '') {
                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';') {
                    if (!$mysqli->query($templine)) {
                        print('Error performing query \'<strong>' . $templine . '\': ' . $mysqli->error . '<br /><br />');
                    }
                    $templine = '';
                }
            }
        }
        echo 'Importing finished. Now, Delete the import file.'.PHP_EOL.PHP_EOL;
        die;
    }
}
