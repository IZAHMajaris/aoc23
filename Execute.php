<?php

class AOCClass
{
    public function importData()
    {
        $fileData = file('./input', FILE_IGNORE_NEW_LINES);

        if (!is_array($fileData)) {
            return [];
        }

        return $fileData;
    }

    /* Helper Funktionen - Start */

    private function convertTextNumbers($row)
    {
        $numbers = [
            "one" => 1,
            "two" => 2,
            "three" => 3,
            "four" => 4,
            "five" => 5,
            "six" => 6,
            "seven" => 7,
            "eight" => 8,
            "nine" => 9,
        ];

        $row_array = str_split($row);
        $haystack = "";

        foreach($row_array as $key => $character) {

            $haystack .= (!is_numeric($character)) ? $character : "";

            foreach ($numbers as $key2 => $number) {

                if (str_contains($haystack, $key2)) {
                    $row = str_replace($key2, $number, $row);
                    $haystack = str_replace($haystack, "", $haystack);
                }
            }
        }
        return $row;
    }

    /* Helper Funktionen - Ende */

    public function Aufgabe01() {
        $data = $this->importData();
        $values = [];

        foreach($data as $row){
            $row_array = str_split($row);
            $numbers_in_row = [];
            foreach($row_array as $character){
                if(is_numeric($character)){
                    $numbers_in_row[] = $character;
                }
            }

            $anzahl_nummern = count($numbers_in_row);

            if($anzahl_nummern === 1){
                $values[] = (int)($numbers_in_row[0].$numbers_in_row[0]);
            } else {
                $values[] = (int)($numbers_in_row[0].$numbers_in_row[$anzahl_nummern-1]);
            }
        }

        return array_sum($values);
    }

    public function Aufgabe01_B() {
        $digitPairs = [];

        //do Magic here...

        return array_sum($digitPairs);
    }

    public function output() {
        var_dump($this->Aufgabe01_B());
        var_dump($this->Aufgabe01_B()); //Korrektes Ergebnis wäre 53866
    }
}

$b = new AOCClass();
$b->output();

