<?php

namespace Console\Commands;

use System\Crayner\Contracts\Console\Command;

/**
 * @author  Ammar Faizi <ammarfaizi2@gmail.com>
 */


class Serve implements Command
{
    public function prepare($selection, $optional, $command)
    {
    }

    public function argument($ar)
    {
    }

    public function showResult()
    {
    }

    public function execute()
    {
        print "IceTea Development Started !\n\n127.0.0.1:8000\n\n";
        print exec("cd ".realpath(PUBLIC_DIR)." && php -S localhost:8000 --file index.php");
        die;
    }
}
