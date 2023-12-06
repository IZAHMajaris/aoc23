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

    public function makeDataGoodLooking($data) {
        $nice_data = [];

        foreach($data as $row) {
            $parts = explode(":", $row);
            $game_number = explode(" ", $parts[0])[1];
            $rounds = explode(";", $parts[1]);

            $red = 0;
            $green = 0;
            $blue = 0;

            foreach($rounds as $round){
                $line = explode(",", $round);

                foreach($line as $l) {
                    $number = explode(" ", $l)[1];
                    $color = explode(" ", $l)[2];

                    if($color === "red"){
                        if ($number > $red) {
                            $red = $number;
                        }
                    }else if($color === "green") {
                        if ($number > $green) {
                            $green = $number;
                        }
                    }else if($color === "blue"){
                        if ($number > $blue) {
                            $blue = $number;
                        }
                    }
                }
            }

            $nice_data[$game_number] = ['r'=>$red, 'g'=>$green,'b'=>$blue];
        }

        return $nice_data;
    }

    /* Helper Funktionen - Ende */

    public function Aufgabe01() {
        $nice_data = $this->makeDataGoodLooking($this->importData());
        $correct_games = [];

        foreach($nice_data as $game_number =>$data) {
            if($data['r'] <= 12 && $data['g'] <= 13 && $data['b'] <= 14){
                $correct_games[] = $game_number;
            }

        }

        return array_sum($correct_games);
    }

    public function Aufgabe02()
    {
        $nice_data = $this->makeDataGoodLooking($this->importData());
        $correct_games = [];

        foreach($nice_data as $game_number =>$data) {
            $correct_games[] = $data['r']*$data['g']*$data['b'];
        }

        return array_sum($correct_games);
    }

    public function output() {
        var_dump($this->Aufgabe01());
        var_dump($this->Aufgabe02());
    }
}

$b = new AOCClass();
$b->output();

