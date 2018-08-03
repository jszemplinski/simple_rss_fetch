<?php

namespace JacekSzemplinski\src\services;


class RSSService {

    public function getDataFromFeed($feedUrl) {
        try {
            $content = file_get_contents($feedUrl);
            if (!$content) {
                return NULL;
            }
            $xml = new \SimpleXMLElement($content);
        } catch (\Exception $e) {
            return NULL;
        }

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