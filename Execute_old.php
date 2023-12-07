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
                    $matches_character1 = substr_count($cards, $doublets[0]);
                    $matches_character2 = substr_count($cards, $doublets[1]);


                    if($matches_character1 === 3 || $matches_character2 === 3){
                        //Full house
                        if($matches_character1 === 3){
                            $highest_priority_character = $this->getPriorityOfCharacter($doublets[0]);
                        }else{
                            $highest_priority_character = $this->getPriorityOfCharacter($doublets[1]);
                        }
                        $result["full_house"][$highest_priority_character] = [explode(' ', $row)[0], explode(' ', $row)[1]];
                    }else{
                        //Two Pair
                        $highest_priority_character = max($this->getPriorityOfCharacter($doublets[0]), $this->getPriorityOfCharacter($doublets[1]));
                        $result["two_pair"][$highest_priority_character] = [explode(' ', $row)[0], explode(' ', $row)[1]];
                    }

                } else if($amountOfDoublets === 1) {
                    //1Paar oder 3-4 Wiederholungen
                    $matches_character = substr_count($cards, $doublets[0]);

                    if($matches_character === 2) {
                        //One pair
                        $result["one_pair"][$this->getPriorityOfCharacter($doublets[0])] = [explode(' ', $row)[0], explode(' ', $row)[1]];
                    } else if($matches_character === 3) {
                        //Three of a kind
                        $result["three_of_a_kind"][$this->getPriorityOfCharacter($doublets[0])] = [explode(' ', $row)[0], explode(' ', $row)[1]];
                    } else if($matches_character === 4) {
                        //Four of a kind
                        $result["four_of_a_kind"][$this->getPriorityOfCharacter($doublets[0])] = [explode(' ', $row)[0], explode(' ', $row)[1]];
                    }
                } else {
                    //High Card
                    $string = '23456789TJQKA';

                    if (substr_count($string, $cards) > 0) {
                        $result["high_card"][$this->getPriorityOfCharacter($cards[4])] = [explode(' ', $row)[0], explode(' ', $row)[1]];
                    } else {
//                        $biggest_priority = "";
//                        $cards_array = str_split($cards);
//                        foreach ($cards_array as $c) {
//                            if ($this->getPriorityOfCharacter($c) > $biggest_priority) {
//                                $biggest_priority = $this->getPriorityOfCharacter($c);
//                            }
//                        }
//                        $result["high_card"][$biggest_priority] = [explode(' ', $row)[0], explode(' ', $row)[1]];
                    }
                }
            }
        }
        return $result;
    }

    /* Helper Funktionen - Ende */

    public function Aufgabe01() {
        $data = $this->importData();
        $rounds_by_type = $this->sortByType($data);
        $results_ordered = [];
        $results = [];

        if(array_key_exists('high_card', $rounds_by_type)) {
            //High Card
            $high_card = $rounds_by_type['high_card'];
            ksort($high_card);
            foreach ($high_card as $cards) {
                $results_ordered[] = $cards[1];
            }
        }

        if(array_key_exists('one_pair', $rounds_by_type)) {
            //One pair
            $one_pair = $rounds_by_type['one_pair'];
            ksort($one_pair);
            foreach ($one_pair as $cards) {
                $results_ordered[] = $cards[1];
            }
        }

        if(array_key_exists('two_pair', $rounds_by_type)) {
            //Two Pair
            $two_pair = $rounds_by_type['two_pair'];
            ksort($two_pair);
            foreach ($two_pair as $cards) {
                $results_ordered[] = $cards[1];
            }
        }

        if(array_key_exists('three_of_a_kind', $rounds_by_type)) {
            //Three of a kind
            $three_of_a_kind = $rounds_by_type['three_of_a_kind'];
            ksort($three_of_a_kind);
            foreach ($three_of_a_kind as $cards) {
                $results_ordered[] = $cards[1];
            }
        }

        if(array_key_exists('full_house', $rounds_by_type)) {
            //Full house
            $full_house = $rounds_by_type['full_house'];
            ksort($full_house);
            foreach ($full_house as $cards) {
                $results_ordered[] = $cards[1];
            }
        }

        if(array_key_exists('four_of_a_kind', $rounds_by_type)) {
            //Four of a kind
            $four_of_a_kind = $rounds_by_type['four_of_a_kind'];
            ksort($four_of_a_kind);
            foreach ($four_of_a_kind as $cards) {
                $results_ordered[] = $cards[1];
            }
        }

        if(array_key_exists('five_of_a_kind', $rounds_by_type)){
            //Five of a kind
            $five_of_a_kind = $rounds_by_type['five_of_a_kind'];
            ksort($five_of_a_kind);
            foreach($five_of_a_kind as $cards){
                $results_ordered[] = $cards[1];
            }
        }

        foreach($results_ordered as $key=>$r){
            $value = (int)$r * ($key+1);
            $results[] = $value;
        }

        var_dump($results_ordered);

        return $data;
    }

    public function output() {
        $this->Aufgabe01();
    }
}

$b = new AOCClass();
$b->output();

