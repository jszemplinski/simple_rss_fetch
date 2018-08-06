<?php

namespace JacekSzemplinski\src;

require_once "services/RSSService.php";
require_once "services/CSVService.php";

use JacekSzemplinski\src\services\CSVService;
use JacekSzemplinski\src\services\RSSService;

class Commands
{
    private $availableCommands;
    private $RSSService;
    private $CSVService;

    public function __construct()
    {
        $this->availableCommands = array(
            "csv:simple" => array(
                "method" => "csvSimple",
                "argCount" => 2
            ),
            "csv:extended" => array(
                "method" => "csvExtended",
                "argCount" => 2
            )
        );
        $this->RSSService = new RSSService();
        $this->CSVService = new CSVService();
    }

    public function run($args)
    {
        if (count($args) <= 1) {
            print("I'm sorry but I'm having a hard time understanding you :c\n");
            return false;
        }
        $cmd = $args[1];
        unset($args[0], $args[1]);

        if (!isset($this->availableCommands[$cmd])) {
            print("Sorry, no such command here!\n");
            return false;
        }
        if (count($args) != $this->availableCommands[$cmd]["argCount"]) {
            print("I believe you got this one wrong, make sure that number of arguments matches!\n");
            return false;
        }

        try {
            $method = (new \ReflectionMethod(get_class($this), $this->availableCommands[$cmd]["method"]))->getClosure($this);
        } catch (\ReflectionException $e) {
            print("Oh no, something wrong happened :O Try again, would you?\n");
            return false;
        }
        $method(array_values($args));
        return true;
    }

    private function csvSimple($args)
    {
        $url = $args[0];
        $path = $args[1] . ".csv";

        $data = $this->RSSService->getDataFromFeed($url);
        if ($data == null) {
            print("It seems like there was a problem with getting data from this URL... You sure it's right?\n");
            return;
        }

        $columns = array(
            "title", "description", "link", "pubDate", "creator"
        );

        $this->CSVService->createCSVFromData($data, $columns, $path);
    }

    private function csvExtended($args)
    {
        $url = $args[0];
        $path = $args[1] . ".csv";

        $data = $this->RSSService->getDataFromFeed($url);
        if ($data == null) {
            print("It seems like there was a problem with getting data from this URL... You sure it's right?\n");
            return;
        }

        $this->CSVService->appendDataToCSV($data, $path);
    }

}