<?php

class ethelo {
    const EMPTY = 0;
    const PLAYER1 = 1;
    const PLAYER2 = 2;
    const HELPER = 3;

    public static function make($width = 8, $height = 8){
        if($width % 2 == 1)++$width;
        if($height % 2 == 1)++$height;
        $table = array();
        for($x = 0; $x < $width; ++$x){
            $table[$x] = array();
            for($y = 0; $y < $height; ++$y)
                $table[$x][$y] = 0;
        }
        $w2 = $width / 2;
        $h2 = $height / 2;
        $table[$w2 - 1][$h2 - 1] = 1;
        $table[$w2][$h2] = 1;
        $table[$w2 - 1][$h2] = 2;
        $table[$w2][$h2 - 1] = 2;
        return $table;
    }
    public static function helper(&$table, $player = 1){
        $that = $player == 1 ? 2 : 1;
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$y]); ++$y)
                if($table[$x][$y] == 3)
                    $table[$x][$y] = 0;
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$y]); ++$y){
                if($table[$x][$y] != $player)continue;
                $t = false;
                for($k = 0; isset($table[$x - $k][$y]); ++$k)
                    if($table[$x - $k][$y] == $player)$t = false;
                    elseif($table[$x - $k][$y] == $that)$t = true;
                    elseif($table[$x - $k][$y] == 0)break;
                if($t)$table[$x - $k][$y] = 3;
                $t = false;
                for($k = 0; isset($table[$x + $k][$y]); ++$k)
                    if($table[$x + $k][$y] == $player)$t = false;
                    elseif($table[$x + $k][$y] == $that)$t = true;
                    elseif($table[$x + $k][$y] == 0)break;
                if($t)$table[$x + $k][$y] = 3;
                $t = false;
                for($k = 0; isset($table[$x][$y - $k]); ++$k)
                    if($table[$x][$y - $k] == $player)$t = false;
                    elseif($table[$x][$y - $k] == $that)$t = true;
                    elseif($table[$x][$y - $k] == 0)break;
                if($t)$table[$x][$y - $k] = 3;
                $t = false;
                for($k = 0; isset($table[$x][$y + $k]); ++$k)
                    if($table[$x][$y + $k] == $player)$t = false;
                    elseif($table[$x][$y + $k] == $that)$t = true;
                    elseif($table[$x][$y + $k] == 0)break;
                if($t)$table[$x][$y + $k] = 3;
                $t = false;
                for($k = 0; isset($table[$x - $k][$y - $k]); ++$k)
                    if($table[$x - $k][$y - $k] == $player)$t = false;
                    elseif($table[$x - $k][$y - $k] == $that)$t = true;
                    elseif($table[$x - $k][$y - $k] == 0)break;
                if($t)$table[$x - $k][$y - $k] = 3;
                $t = false;
                for($k = 0; isset($table[$x + $k][$y - $k]); ++$k)
                    if($table[$x + $k][$y - $k] == $player)$t = false;
                    elseif($table[$x + $k][$y - $k] == $that)$t = true;
                    elseif($table[$x + $k][$y - $k] == 0)break;
                if($t)$table[$x + $k][$y - $k] = 3;
                $t = false;
                for($k = 0; isset($table[$x - $k][$y + $k]); ++$k)
                    if($table[$x - $k][$y + $k] == $player)$t = false;
                    elseif($table[$x - $k][$y + $k] == $that)$t = true;
                    elseif($table[$x - $k][$y + $k] == 0)break;
                if($t)$table[$x - $k][$y + $k] = 3;
                $t = false;
                for($k = 0; isset($table[$x + $k][$y + $k]); ++$k)
                    if($table[$x + $k][$y + $k] == $player)$t = false;
                    elseif($table[$x + $k][$y + $k] == $that)$t = true;
                    elseif($table[$x + $k][$y + $k] == 0)break;
                if($t)$table[$x + $k][$y + $k] = 3;
            }
    }
    public static function sizex($table){
        return count($table);
    }
    public static function sizey($table){
        return count($table[0]);
    }
    public static function set(&$table, $x, $y, $value){
        $table[$x][$y] = $value;
    }
    public static function get($table, $x, $y){
        return $table[$x][$y];
    }
    public static function play(&$table, $xo, $yo, $player){
        if($table[$xo][$yo] != 3)return false;
        $that = $player == 1 ? 2 : 1;
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$y]); ++$y)
                if($table[$x][$y] == 3)
                    $table[$x][$y] = 0;
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$y]); ++$y){
                if($table[$x][$y] != $player)continue;
                if($yo == $y && $x > $xo){
                    $t = false;
                    for($k = 0; isset($table[$x - $k][$y]); ++$k)
                        if($table[$x - $k][$y] == $player)$t = false;
                        elseif($table[$x - $k][$y] == $that)$t = true;
                        elseif($table[$x - $k][$y] == 0)break;
                    if($t && $x - $k == $xo)
                        while(--$k > 0)
                            $table[$x - $k][$y] = $player;
                }
                if($yo == $y && $x < $xo){
                    $t = false;
                    for($k = 0; isset($table[$x + $k][$y]); ++$k)
                        if($table[$x + $k][$y] == $player)$t = false;
                        elseif($table[$x + $k][$y] == $that)$t = true;
                        elseif($table[$x + $k][$y] == 0)break;
                    if($t && $x + $k == $xo)
                        while(--$k > 0)
                            $table[$x + $k][$y] = $player;
                }
                if($xo == $x && $y > $yo){
                    $t = false;
                    for($k = 0; isset($table[$x][$y - $k]); ++$k)
                        if($table[$x][$y - $k] == $player)$t = false;
                        elseif($table[$x][$y - $k] == $that)$t = true;
                        elseif($table[$x][$y - $k] == 0)break;
                    if($t && $y - $k == $yo)
                        while(--$k > 0)
                            $table[$x][$y - $k] = $player;
                }
                if($xo == $x && $y < $yo){
                    $t = false;
                    for($k = 0; isset($table[$x][$y + $k]); ++$k)
                        if($table[$x][$y + $k] == $player)$t = false;
                        elseif($table[$x][$y + $k] == $that)$t = true;
                        elseif($table[$x][$y + $k] == 0)break;
                    if($t && $y + $k == $yo)
                        while(--$k > 0)
                            $table[$x][$y + $k] = $player;
                }
                if($xo < $x && $yo < $y && $x - $xo == $y - $yo){
                    $t = false;
                    for($k = 0; isset($table[$x - $k][$y - $k]); ++$k)
                        if($table[$x - $k][$y - $k] == $player)$t = false;
                        elseif($table[$x - $k][$y - $k] == $that)$t = true;
                        elseif($table[$x - $k][$y - $k] == 0)break;
                    if($t && $x - $k == $xo && $y - $k == $yo)
                        while(--$k > 0)
                            $table[$x - $k][$y - $k] = $player;
                }
                if($xo > $x && $yo < $y && $xo - $x == $y - $yo){
                    $t = false;
                    for($k = 0; isset($table[$x + $k][$y - $k]); ++$k)
                        if($table[$x + $k][$y - $k] == $player)$t = false;
                        elseif($table[$x + $k][$y - $k] == $that)$t = true;
                        elseif($table[$x + $k][$y - $k] == 0)break;
                    if($t && $x + $k == $xo && $y - $k == $yo)
                        while(--$k > 0)
                            $table[$x + $k][$y - $k] = $player;
                }
                if($xo < $x && $yo > $y && $x - $xo == $yo - $y){
                    $t = false;
                    for($k = 0; isset($table[$x - $k][$y + $k]); ++$k)
                        if($table[$x - $k][$y + $k] == $player)$t = false;
                        elseif($table[$x - $k][$y + $k] == $that)$t = true;
                        elseif($table[$x - $k][$y + $k] == 0)break;
                    if($t && $x - $k == $xo && $y + $k == $yo)
                        while(--$k > 0)
                            $table[$x - $k][$y + $k] = $player;
                }
                if($xo > $x && $yo > $y && $xo - $x == $yo - $y){
                    $t = false;
                    for($k = 0; isset($table[$x + $k][$y + $k]); ++$k)
                        if($table[$x + $k][$y + $k] == $player)$t = false;
                        elseif($table[$x + $k][$y + $k] == $that)$t = true;
                        elseif($table[$x + $k][$y + $k] == 0)break;
                    if($t && $x + $k == $xo && $y + $k == $yo)
                        while(--$k > 0)
                            $table[$x + $k][$y + $k] = $player;
                }
            }
        $table[$xo][$yo] = $player;
        return true;
    }
    public static function helperplay(&$table, $x, $y, $player){
        $that = $player == 1 ? 2 : 1;
        if(!self::play($table, $x, $y, $player))
            return false;
        self::helper($table, $that);
        return true;
    }
    public static function helpermake($width = 8, $height = 8){
        $table = self::make($width, $height);
        self::helper($table);
        return $table;
    }
    public static function playercount($table, $player){
        $count = 0;
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$x][$y]); ++$y)
                if($table[$x][$y] == $player)
                    ++$count;
        return $count;
    }
    public static function check($table){
        $icons = array(0, 0, 0, 0);
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$x][$y]); ++$y)
                ++$icons[$table[$x][$y]];
        if($icons[0] == 0)
            if($icons[1] > $icons[2])
                return 1;
            elseif($icons[2] > $icons[1])
                return 2;
            else return 3;
        return 0;
    }
    public static function helpers($table){
        $helpers = array();
        for($x = 0; isset($table[$x]); ++$x)
            for($y = 0; isset($table[$x][$y]); ++$y)
                if($table[$x][$y] == 3)
                    $helpers[] = array($x, $y);
        return $helpers;
    }
    public static function bot(&$table, $player = 2){
        $helpers = self::helpers($table);
        $max = 0;
        foreach($helpers as &$helper){
            $tmp = $table;
            if(!self::play($tmp, $helper[0], $helper[1], $player))return false;
            $helper = $tmp;
            $helper = array($helper, self::playercount($table, $player));
            if($max < $helper[1])
                $max = $helper[1];
        }
        $maxs = array();
        for($i = 0; isset($helpers[$i]); ++$i)
            if($helpers[$i][1] == $max)
                $maxs[] = $helpers[$i][0];
        $table = $maxs[array_rand($maxs)];
        return true;
    }
    public static function helperbot(&$table, $player = 2){
        $that = $player == 1 ? 2 : 1;
        if(!self::bot($table, $player))
            return false;
        self::helper($table, $that);
        return true;
    }
    public static function map($table, $empty = '  ', $player1 = ' X', $player2 = ' O', $helper = ' .'){
        $map = "";
        $list = array($empty, $player1, $player2, $helper);
        for($x = 0; isset($table[$x]); ++$x){
            for($y = 0; isset($table[$x][$y]); ++$y)
                $map .= $list[$table[$x][$y]];
            if(isset($table[$x + 1]))
                $map .= "\n";
        }
        return $map;
    }
}

?>