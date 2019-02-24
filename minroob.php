<?php

class minroob {
    const EEMPTY = 0;
    const PLAYER1 = 1;
    const PLAYER2 = 2;
    const MIN = 3;
    const MIN1 = 4;
    const MIN2 = 5;

    /*
        empty    0
        player1  1
        player2  2
        Min      3-5
        number   6-15
        view     x+16
    */

    public static function make($width = 8, $height = 8, $min = 15){
        $table = array();
        if($min >= $width * $height)return false;
        for($x = 0; $x < $width; ++$x){
            $table[$x] = array();
            for($y = 0; $y < $height; ++$y)
                $table[$x][$y] = 0;
        }
        for($i = 0; $i < $min; ++$i){
            do {
                $x = rand(0, $width - 1);
                $y = rand(0, $height - 1);
            }while($table[$x][$y] == 3);
            $table[$x][$y] = 3;
            if(isset($table[$x][$y - 1]))
            if($table[$x][$y - 1] == 0)$table[$x][$y - 1] = 6;
            elseif($table[$x][$y - 1] != 3)++$table[$x][$y - 1];
            if(isset($table[$x][$y + 1]))
            if($table[$x][$y + 1] == 0)$table[$x][$y + 1] = 6;
            elseif($table[$x][$y + 1] != 3)++$table[$x][$y + 1];
            if(isset($table[$x - 1][$y]))
            if($table[$x - 1][$y] == 0)$table[$x - 1][$y] = 6;
            elseif($table[$x - 1][$y] != 3)++$table[$x - 1][$y];
            if(isset($table[$x + 1][$y]))
            if($table[$x + 1][$y] == 0)$table[$x + 1][$y] = 6;
            elseif($table[$x + 1][$y] != 3)++$table[$x + 1][$y];
            if(isset($table[$x - 1][$y - 1]))
            if($table[$x - 1][$y - 1] == 0)$table[$x - 1][$y - 1] = 6;
            elseif($table[$x - 1][$y - 1] != 3)++$table[$x - 1][$y - 1];
            if(isset($table[$x + 1][$y - 1]))
            if($table[$x + 1][$y - 1] == 0)$table[$x + 1][$y - 1] = 6;
            elseif($table[$x + 1][$y - 1] != 3)++$table[$x + 1][$y - 1];
            if(isset($table[$x - 1][$y + 1]))
            if($table[$x - 1][$y + 1] == 0)$table[$x - 1][$y + 1] = 6;
            elseif($table[$x - 1][$y + 1] != 3)++$table[$x - 1][$y + 1];
            if(isset($table[$x + 1][$y + 1]))
            if($table[$x + 1][$y + 1] == 0)$table[$x + 1][$y + 1] = 6;
            elseif($table[$x + 1][$y + 1] != 3)++$table[$x + 1][$y + 1];
        }
        return $table;
    }
    public static function set(&$table, $x, $y, $value){
        $table[$x][$y] = $value;
    }
    public static function get(&$table, $x, $y){
        return $table[$x][$y];
    }
    public static function view(&$table, $x, $y, $player = 0){
        if($table[$x][$y] > 16)return 0;
        if($table[$x][$y] == 3){
            if($player === false)$table[$x][$y] += 14;
            else $table[$x][$y] += $player;
            return 3;
        }
        if($table[$x][$y] == 0){
            $table[$x][$y] += 16;
            if(isset($table[$x][$y - 1]))self::view($table, $x, $y - 1);
            if(isset($table[$x][$y + 1]))self::view($table, $x, $y + 1);
            if(isset($table[$x - 1][$y]))self::view($table, $x - 1, $y);
            if(isset($table[$x + 1][$y]))self::view($table, $x + 1, $y);
            if(isset($table[$x - 1][$y - 1]))self::view($table, $x - 1, $y - 1);
            if(isset($table[$x + 1][$y - 1]))self::view($table, $x + 1, $y - 1);
            if(isset($table[$x - 1][$y + 1]))self::view($table, $x - 1, $y + 1);
            if(isset($table[$x + 1][$y + 1]))self::view($table, $x + 1, $y + 1);
            return 1;
        }
        $table[$x][$y] += 16;
        return 2;
    }
    public static function unview(&$table, $x, $y){
        if($table[$x][$y] < 16)return 0;
        if($table[$x][$y] == 3){
            $table[$x][$y] %= 16;
            return 3;
        }
        if($table[$x][$y] == 0){
            $table[$x][$y] %= 16;
            if(isset($table[$x][$y - 1]))self::view($table, $x, $y - 1);
            if(isset($table[$x][$y + 1]))self::view($table, $x, $y + 1);
            if(isset($table[$x - 1][$y]))self::view($table, $x - 1, $y);
            if(isset($table[$x + 1][$y]))self::view($table, $x + 1, $y);
            if(isset($table[$x - 1][$y - 1]))self::view($table, $x - 1, $y - 1);
            if(isset($table[$x + 1][$y - 1]))self::view($table, $x + 1, $y - 1);
            if(isset($table[$x - 1][$y + 1]))self::view($table, $x - 1, $y + 1);
            if(isset($table[$x + 1][$y + 1]))self::view($table, $x + 1, $y + 1);
            return 1;
        }
        $table[$x][$y] %= 16;
        return 2;
    }
    public static function viewall(&$table){
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$x][$y]); ++$y)
                self::view($table, $x, $y);
    }
    public static function sizex($table){
        return count($table);
    }
    public static function sizey($table){
        return count($table[0]);
    }
    public static function setmin(&$table, $x, $y){
        $width = count($table) - 1;
        $height = count($table[0]) - 1;
        do {
            $x = rand(0, $width);
            $y = rand(0, $height);
        }while($table[$x][$y] == 3);
        $table[$x][$y] = 3;
        if(isset($table[$x][$y - 1]))
        if($table[$x][$y - 1] == 0)$table[$x][$y - 1] = 6;
        elseif($table[$x][$y - 1] != 3)++$table[$x][$y - 1];
        if(isset($table[$x][$y + 1]))
        if($table[$x][$y + 1] == 0)$table[$x][$y + 1] = 6;
        elseif($table[$x][$y + 1] != 3)++$table[$x][$y + 1];
        if(isset($table[$x - 1][$y]))
        if($table[$x - 1][$y] == 0)$table[$x - 1][$y] = 6;
        elseif($table[$x - 1][$y] != 3)++$table[$x - 1][$y];
        if(isset($table[$x + 1][$y]))
        if($table[$x + 1][$y] == 0)$table[$x + 1][$y] = 6;
        elseif($table[$x + 1][$y] != 3)++$table[$x + 1][$y];
        if(isset($table[$x - 1][$y - 1]))
        if($table[$x - 1][$y - 1] == 0)$table[$x - 1][$y - 1] = 6;
        elseif($table[$x - 1][$y - 1] != 3)++$table[$x - 1][$y - 1];
        if(isset($table[$x + 1][$y - 1]))
        if($table[$x + 1][$y - 1] == 0)$table[$x + 1][$y - 1] = 6;
        elseif($table[$x + 1][$y - 1] != 3)++$table[$x + 1][$y - 1];
        if(isset($table[$x - 1][$y + 1]))
        if($table[$x - 1][$y + 1] == 0)$table[$x - 1][$y + 1] = 6;
        elseif($table[$x - 1][$y + 1] != 3)++$table[$x - 1][$y + 1];
        if(isset($table[$x + 1][$y + 1]))
        if($table[$x + 1][$y + 1] == 0)$table[$x + 1][$y + 1] = 6;
        elseif($table[$x + 1][$y + 1] != 3)++$table[$x + 1][$y + 1];
    }
    public static function earthcount($table){
        $players = array(
            1 => 0,
            2 => 0
        );
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$x][$y]); ++$y)
                if($table[$x][$y] == 1 || $table[$x][$y] == 2)
                    ++$players[$table[$x][$y]];
        return $players;
    }
    public static function mincount($table){
        $players = array(
            1 => 0,
            2 => 0
        );
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$x][$y]); ++$y)
                if($table[$x][$y] == 4 || $table[$x][$y] == 5)
                    ++$players[$table[$x][$y] - 3];
        return $players;
    }
    public static function play(&$table, $x, $y, $player){
        $that = $player == 1 ? 2 : 1;
        if($table[$x][$y] > 16)return 0;
        if($table[$x][$y] == $player || $table[$x][$y] == $player + 3)return 1;
        if($table[$x][$y] == $that || $table[$x][$y] == $that + 3)return 2;
        if($table[$x][$y] >= 6 && $table[$x][$y] <= 15){
            $table[$x][$y] += 16;
            return 3;
        }if($table[$x][$y] == 3){
            $table[$x][$y] += $player;
            return 4;
        }$table[$x][$y] = $player;
        if(isset($table[$x - 1][$y]))self::play($table, $x - 1, $y, $player);
        if(isset($table[$x + 1][$y]))self::play($table, $x + 1, $y, $player);
        if(isset($table[$x][$y - 1]))self::play($table, $x, $y - 1, $player);
        if(isset($table[$x][$y + 1]))self::play($table, $x, $y + 1, $player);
        if(isset($table[$x - 1][$y - 1]))self::play($table, $x - 1, $y - 1, $player);
        if(isset($table[$x - 1][$y + 1]))self::play($table, $x - 1, $y + 1, $player);
        if(isset($table[$x + 1][$y - 1]))self::play($table, $x + 1, $y - 1, $player);
        if(isset($table[$x + 1][$y + 1]))self::play($table, $x + 1, $y + 1, $player);
        return 5;
    }
    public static function check($table){
        $icons = array(0, 0, 0, 0, 0, 0);
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$x][$y]); ++$y)
                if($table[$x][$y] % 16 < 6)
                    ++$icons[$table[$x][$y] % 16];
        if($icons[0] == 0 || $icons[1] == 0)
            if($icons[4] > $icons[5])
                return 1;
            elseif($icons[5] > $icons[4])
                return 2;
            else return 3;
        return 0;
    }
    public static function emptys($table){
        $emptys = array();
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$x][$y]); ++$y)
                if($table[$x][$y] == 0)
                    $empty[] = array($x, $y);
        return $emptys;
    }
    public static function mapview($table, $list){
        $map = "";
        for($x = 0; isset($table[$x]); ++$x){
            for($y = 0; isset($table[$x][$y]); ++$y)
                $map .= $list[$table[$x][$y] % 16];
            if(isset($table[$x + 1]))
                $map .= "\n";
        }
        return $map;
    }
    public static function map($table, $list){
        $map = "";
        for($x = 0; isset($table[$x]); ++$x){
            for($y = 0; isset($table[$x][$y]); ++$y)
                if(in_array($table[$x][$y], range(3, 16)))
                    $map .= $list[0];
                else
                    $map .= $list[$table[$x][$y] % 16];
            if(isset($table[$x + 1]))
                $map .= "\n";
        }
        return $map;
    }
}

?>