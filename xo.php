<?php

class xo {
    const VERY_EASY = 0;
    const EASY = 1;
    const NORMAL = 2;
    const HARD = 3;
    const VERY_HARD = 4;
    const WINNER = 5;
    const NOTWINER = 6;
    const EMPTY = 0;
    const PLAYER1 = 1;
    const PLAYER2 = 2;
    const EQUAL = 3;

    private static $win = array(
        array(0, 1, 2),
        array(3, 4, 5),
        array(6, 7, 8),
        array(0, 4, 8),
        array(2, 4, 6),
        array(0, 3, 6),
        array(1, 4, 7),
        array(2, 5, 8)
    );
    private static $bot = array(
        array(
            array(1, 2, 3, 6, 4, 8),
            array(0, 2, 4, 7),
            array(0, 1, 5, 8, 4, 6),
            array(4, 5, 0, 6),
            array(0, 8, 1, 7, 2, 6, 3, 5),
            array(3, 4, 2, 8),
            array(0, 3, 2, 4, 7, 8),
            array(1, 4, 6, 8),
            array(0, 4, 2, 5, 6, 7)
        ), array(
            array(array(1, 4, 5), array(8, 2, 6)),
            array(array(0, 2, 4), array(7, 3, 5)),
            array(array(1, 4, 5), array(0, 6, 8)),
            array(array(0, 4, 6), array(5, 1, 7)),
            array(array(0, 1, 2, 3, 5, 6, 7, 8), array(0, 1, 2, 3, 5, 6, 7, 8)),
            array(array(2, 4, 8), array(1, 3, 7)),
            array(array(3, 4, 7), array(0, 2, 8)),
            array(array(4, 6, 8), array(1, 3, 5)),
            array(array(4, 5, 7), array(0, 2, 6))
        )
    );
    private static $lvl = array(
        array(6, 1),
        array(3, 4),
        array(2, 9),
        array(1, 13),
        array(1, 26),
        array(0, 1),
        array(1, 0)
    );

    private static function repeat($array, $count){
        $repeat = array();
        while(--$count >= 0)
            $repeat[] = $array;
        if($repeat === array())
            return array();
        return call_user_func_array('array_merge', $repeat);
    }

    public static function make(){
        return array(
            0, 0, 0,
            0, 0, 0,
            0, 0, 0
        );
    }
    public static function set(&$table, $x, $y, $player){
        $table[$x * 3 + $y] = $player;
    }
    public static function get($table, $x, $y){
        return $table[$x * 3 + $y];
    }
    public static function play(&$table, $x, $y, $player){
        $that = $player == 1 ? 2 : 1;
        if($table[$x * 3 + $y] == $player)return 1;
        if($table[$x * 3 + $y] == $that)return 2;
        $table[$x * 3 + $y] = 0;
        return 0;
    }
    public static function check($table){
        foreach(self::$win as $win)
            if($table[$win[0]] == $table[$win[1]] && $table[$win[0]] == $table[$win[2]])
                return $table[$win[0]];
        foreach($table as $win)
            if($win == 0)
                return 0;
        return 3;
    }
    public static function emptys($table){
        $emptys = array();
        foreach($table as $n => $home)
            if($home == 0)
                $emptys[] = $n;
        return $emptys;
    }
    public static function bot(&$table, $player = 1, $level = 3){
        if($player == 1)$that = 2;
        else $that = 1;
        if(!is_array($level))
            $level = self::$lvl[$level];
        $level[2] = ceil($level[0] / $level[1] * 1.5);
        $select = array(array(), array(), array());
        foreach(self::$bot[0] as $n => $ch)
            if($table[$n] == $that)
                for($i = 0; isset($ch[$i]); $i += 2)
                    if($table[$ch[$i]] == $that)
                        $select[0][] = $ch[$i + 1];
                    elseif($table[$ch[$i + 1]] == $that)
                        $select[0][] = $ch[$i];
        foreach(self::$bot[0] as $n => $ch)
            if($table[$n] == $player)
                for($i = 0; isset($ch[$i]); $i += 2)
                    if($table[$ch[$i]] == $player)
                        $select[1][] = $ch[$i + 1];
                    elseif($table[$ch[$i + 1]] == $player)
                        $select[1][] = $ch[$i];
        if($select[0] === array() && $select[1] === array() && $level[2] == 0)
            $level[2] = true;
        foreach(self::$bot[1] as $n => $ch)
            if($table[$n] == $player){
                foreach($ch[0] as $i)
                    if($table[$i] == 0 && ($level[2] === true || rand(0, $level[2]) !== 0))
                        $select[2][] = $i;
                foreach($ch[1] as $i)
                    if($table[$i] == 0 && ($level[2] !== true && rand(0, $level[2]) == 1))
                        $select[2][] = $i;
            }
        if($level[2] === true)$level[2] = 1;
        $select = array_merge(
            self::repeat($select[0], $level[0]),
            self::repeat($select[1], $level[1]),
            self::repeat($select[2], $level[2])
        );
        if($select == array()){
            $emptys = self::emptys($table);
            if($emptys === array())return false;
            $table[$emptys[array_rand($emptys)]] = $player;
            return true;
        }
        $table[$select[array_rand($select)]] = $player;
        return true;
    }
    public static function map($table, $empty = '  ', $player1 = ' X', $player2 = ' O'){
        $icons = array($empty, $player1, $player2);
        return $icons[$table[0]] . $icons[$table[1]] . $icons[$table[2]] . "\n" .
               $icons[$table[3]] . $icons[$table[4]] . $icons[$table[5]] . "\n" .
               $icons[$table[6]] . $icons[$table[7]] . $icons[$table[8]];
    }
}

?>