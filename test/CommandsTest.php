<?php

namespace JacekSzemplinski\test;

use JacekSzemplinski\src\Commands;
use PHPUnit\Framework\TestCase;

final class CommandsTest extends TestCase {

    private function getCommandsInstance() {
        return new Commands();
    }

    public function testItCanRunCommandIfItIsAvailable() {
        $instance = $this->getCommandsInstance();

        $args = array("", "csv:simple", "url", "path");
        $result = $instance->run($args);

        $this->assertTrue($result);
    }

    public function testItWillNotExecuteCommandIfItDoesNotExist() {
        $instance = $this->getCommandsInstance();

        $args = array("nonexistingcommand123");
        $result = $instance->run($args);

        $this->assertFalse($result);
    }

    public function testItWillNotExecuteCommandIfItLacksArguments() {
        $instance = $this->getCommandsInstance();

        // Just a command name, no arguments
        $args = array("", "csv:simple");
        $result = $instance->run($args);

        $this->assertFalse($result);
    }

}