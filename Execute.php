<?php

class AOCClass
{
    public function importData()
    {
        $file = file_get_contents('./input', true);
        return explode(PHP_EOL, $file);
    }

    /* Helper Funktionen - Start */

    /* Helper Funktionen - Ende */

    public function Aufgabe01() {
        $data = $this->importData();

        return $data;
    }

    public function output() {
        var_dump($this->Aufgabe01());
    }
}

$b = new AOCClass();
$b->output();

