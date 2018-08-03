<?php

namespace JacekSzemplinski\tests;

use JacekSzemplinski\src\services\CSVService;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

final class CSVServiceTest extends TestCase {

    private $root;
    private $directory;


    public function setUp() {
        $this->root = vfsStream::setup("CSVtestdir");
        $this->directory = "vfs://CSVtestdir/";
    }


    private function getCSVService() {
        return new CSVService();
    }


    public function testItCreatesCSVFromGivenData() {
        // Instantiate our CSVService.
        $service = $this->getCSVService();

        // Get some mock data to put into csv file.
        $columns = array(
            "First", "Second", "Third"
        );
        $data = $this->getMockRows(3, 2);
        $filename = "exampleFilename.csv";

        // Create a file.
        $service->createCSVFromData($data, $columns, $this->directory . $filename);

        // There should be a new file created.
        $this->assertTrue($this->root->hasChild($filename));

        $file = fopen($this->directory . $filename, "r");

        while($line = fgets($file)) {
            // Each row should have equal number of columns.
            $this->assertEquals(count(explode(",", $line)), count($columns));
        }

        fclose($file);
    }


    public function testItAppendsDataToExistingCSV() {
        // Instantiate our CSV Service.
        $service = $this->getCSVService();
        $filename = "exampleFilename.csv";

        // Get some mock data and create CSV file first.
        $columns = array("First", "Second", "Third");
        $data = $this->getMockRows(3, 1);
        $service->createCSVFromData($data, $columns, $this->directory . $filename);

        // Get some more mock data and append it to CSV file created above.
        $dataNew = $this->getMockRows(3, 2);
        $service->appendDataToCSV($dataNew, $this->directory . $filename);

        $file = fopen($this->directory . $filename, "r");

        $line = fgets($file);
        $line = array_map("trim", explode(",", $line));

        // First line shouldn"t change, it should contain columns from initial file.
        $this->assertEquals($line, $columns);

        // Go through remaining lines and make sure they match mock data.
        for($i = 0; $i < count($data); $i++) {
            $line = fgets($file);
            $line = array_map("trim", explode(",", $line));

            $this->assertEquals($line, $data[$i]);
        }

        for($i = 0; $i < count($dataNew); $i++) {
            $line = fgets($file);
            $line = array_map("trim", explode(",", $line));

            $this->assertEquals($line, $dataNew[$i]);
        }

        fclose($file);
    }


    public function testItDoesNotCreateNewFileInExtendedMode() {
        // Instantiate our CSVService.
        $service = $this->getCSVService();
        $filename = "exampleFilename.csv";

        // Try appending data to file that doesn"t exist.
        $service->appendDataToCSV(array(), $this->directory . $filename);

        // It shouldn"t create new file.
        $this->assertFalse($this->root->hasChild($filename));
    }


    private function getMockRows($colCount, $rowCount) {
        $rows = array();
        for($i = 0; $i < $rowCount; $i++) {
            $row = array();
            for($j = 0; $j < $colCount; $j++) {
                array_push($row, "$j");
            }
            array_push($rows, $row);
        }
        return $rows;
    }

}