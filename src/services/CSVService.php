<?php

namespace JacekSzemplinski\src\services;


class CSVService {

    public function createCSVFromData($data, $columnNames, $filename) {
        $file = fopen($filename, "w");

        if(!$file) {
            print("Could not open file: " . $filename . "\n");
            return;
        }

        fputcsv($file, $columnNames);

        foreach($data as $entry) {
            fputcsv($file, $entry);
        }

        fclose($file);

        print("Data was successfully saved to " . $filename . "!\n");
    }

    public function appendDataToCSV($data, $filename) {
        if(!file_exists($filename)) {
            print("Specified file: " . $filename . " does not exist!\n");
            return;
        }

        $file = fopen($filename, "a");

        if(!$file) {
            print("Could not open file: " . $filename . "\n");
            return;
        }

        foreach($data as $entry) {
            fputcsv($file, $entry);
        }

        fclose($file);

        print("Data was successfully appended to file: " . $filename . "!\n");
    }

}