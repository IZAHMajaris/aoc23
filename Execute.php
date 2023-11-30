<?php

class AOCClass
{
    public function importData()
    {
        $file = file_get_contents('./input', true);

        return explode(PHP_EOL, $file);
    }

    public function execute() {
        $test = $this->importData();
        var_dump($test);
    }


}

$b = new AOCClass();
$b->execute();

