<?php

class AOCClass
{
    public const priority = ["2","3","4","5","6","7","8","9","T","J","Q","K","A"];

    public function importData()
    {
        $fileData = file('./input', FILE_IGNORE_NEW_LINES);

        if (!is_array($fileData)) {
            return [];
        }

        return $fileData;
    }

    /* Helper Funktionen - Start */
    public function checkFiveOfAKind($row){
        $cards = explode(' ', $row)[0];
        $split_cards = str_split($cards);

        $pattern = "/^(.)".$split_cards[0].'*$/u';
        $result = false;
        if (preg_match($pattern, $cards)) {
            $result = true;
        }

        return $result;
    }

    public function findDoubletsInString($cardstring): array
    {
        $size = strlen($cardstring);
        $doublets = [];
        for ($i = 0; $i < $size; $i++) {
            $count = 1;
            for ($j = $i + 1; $j < $size; $j++) {
                if ($cardstring[$i] === $cardstring[$j] && $cardstring[$i] !== ' ') {
                    $count++;
                    $cardstring[$j] = '0';
                }
            }
            if ($count > 1 && $cardstring[$i] !== '0') {
                $doublets[] = $cardstring[$i];
            }
        }
        return $doublets;
    }

    public function getPriorityOfCharacter($character): int|string
    {
        $key = array_search($character, self::priority);

        return $key+1;
    }

    public function sortByType($data): array
    {
        $result = [];
        foreach($data as $row){

            if ($this->checkFiveOfAKind($row)){
                //Five of a kind
                $character = substr(explode(' ', $row)[0],0,1);
                $result["five_of_a_kind"][$this->getPriorityOfCharacter($character)] = [explode(' ', $row)[0], explode(' ', $row)[1]];
            } else {
                $cards = explode(' ', $row)[0];
                $doublets = $this->findDoubletsInString($cards);
                $amountOfDoublets = count($doublets);

                if($amountOfDoublets === 2){

                } else if ($amountOfDoublets === 1) {

                } else {
                    $result["high_card"][$this->getPriorityOfCharacter(str_split($cards)[0])] = [explode(' ', $row)[0], explode(' ', $row)[1]];
                }
            }

        }
        var_dump($result["high_card"]);
        return $result;
    }

    /* Helper Funktionen - Ende */

    public function Aufgabe01() {
        $data = $this->importData();
        $rounds_by_type = $this->sortByType($data);


        return $data;
    }

    public function output() {
        $this->Aufgabe01();
    }
}

$b = new AOCClass();
$b->output();

