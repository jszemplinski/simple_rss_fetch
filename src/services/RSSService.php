<?php

namespace JacekSzemplinski\src\services;


use ErrorException;

class RSSService {

    public function getDataFromFeed($feedUrl) {
        set_error_handler(
            function($severity, $message, $file, $line) {
                throw new ErrorException($message, $severity, $severity, $file, $line);
            }
        );

        try {
            $content = file_get_contents($feedUrl);
            $xml = new \SimpleXMLElement($content);
        } catch(\Exception $e) {
            return NULL;
        }

        restore_error_handler();

        $data = array();

        foreach($xml->channel->item as $entry) {
            $entryArr = (array) $entry;
            $item = array(
                "title" => $entryArr["title"],
                "description" => $entryArr["description"],
                "link" => $entryArr["link"],
                "pubDate" => $this->convertDate($entryArr["pubDate"]),
                "creator" => $entryArr["guid"]
            );
            array_push($data, $item);
        }

        return $data;
    }

    private function convertDate($date) {
        $seconds = strtotime($date);
        $date = date("Y-m-d h:i:s", $seconds);
        return $date;
    }

}