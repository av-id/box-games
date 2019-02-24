# box games
You can use this library for telegram robots and online games.

**Games:**
- XO
- Minroon
- Ethelo

## XO
XO games have a table 3 * 3
You can create new table by method make:
```php
$xoTable = xo::make();
```
On $xoTable you have a Empty game.

_home id list:_
- xo::EMPTY      a Empty home id
- xo::PLAYER1    Player number 1 home id
- xo::PLAYER2    Player number 2 home id

_bot levels:_
- xo::VERY_EASY  (6,1)
- xo::EASY       (3,4)
- xo::NORMAL     (2,9)
- xo::HARD       (1,13)
- xo::VERY_HARD  (1,26)
- xo::WINNER     (0,1)
- xo::NOTWINNER  (1,0)

_Win code:_
- 0:     Unknown
- 1:     Player1 winned
- 2:     Player2 winned
- 3:     Equalised

_Play code:_
- 0:     OK! Selectoed
- 1:     Last selected from You
- 2:     Last selected from Opponent

methods list:
```php
xo::set($xoTable, $x, $y, $home_id);         // set a home
xo::get($xoTable, $x, $y);                   // get a home
xo::play($xoTable, $x, $y, $player);         // select a home by Player (play)
xo::bot($xoTable, $player, $level = NORMAL); // run the game by robot as a player
xo::check($xoTable);                         // return Win code
xo::emptys($xoTable);                        // empty homes
xo::map($xoTable, $emptyIcon, $Player1, $Player2);    // Table to string
```

## Minroob
You can create new Minroob table by method make:
```php
$minroobTable = minroob::make( Width = 8, Height = 8, Mine count = 15);
```

_home id:_
- minroob::EMPTY       a Empty home id
- minroob::PLAYER1     Player1 home id
- minroob::PLAYER2     Player2 home id
- minroob::MIN         a Hidden Mine
- minroob::MIN1        a Mine selected by Player 1
- minroob::MIN2        a Mine selected by Player 2
- 6 to 15              Number of around mines (number = homeid - 6)
- 16 to 31             Viewable home id (viewable = homeid + 16)

_Win code:_
- 0:     Unknown
- 1:     Player1 winned
- 2:     Player2 winned
- 3:     Equalised

_Play code:_
- 0:     Last viewabled home
- 1:     Last selected from You
- 2:     Last selected from Opponent
- 3:     OK! Selected number home
- 4:     OK! Selected mine home
- 5:     OK! Selected empty home

methods list:
```php
minroob::set($minroobTable, $x, $y, $homeid);    // set a home
minroob::get($minroobTable, $x, $y);             // get a home
minroob::play($minroobTable, $x, $y, $player);   // select a home by Player (play)
minroob::check($minroobTable);                   // return Win code
minroob::view($minroobTable, $x, $y);            // viewabling a home
minroob::unview($minroobTable, $x, $y);          // unviewabling a home
minroob::viewall($minroobTable);                 // viewabling all homes
minroob::sizex($minroobTable);                   // get table Width
minroob::sizey($minroobTable);                   // get table Height
minroob::setmin($minroobTable, $x, $y);          // set a mine home
minroob::earthcount($minroobTable);              // return [Player1 homes selected, Player2 homes selected]
minroob::mincount($minroobTable);                // return [Player1 mines selected, Player2 mines selected]
minroob::emptys($minroobTable);                  // empty homes
minroob::mapview($minroobTable, [ Unviewable Homeid => Icon, ... ] );    // Table to String (viewable all)
minroob::map($minroobTable, [ Unviewable Homeid => Icon, ... ] );        // Table to String
```

## Ethelo
You can create new Ethelo table by method make:
```php
$etheloTable = ethelo::make( Width = 8, Height = 8);
```

_home id list:_
- ethelo::EMPTY       a Empty home id
- ethelo::PLAYER1     Player1 home id
- ethelo::PLAYER2     Player2 home id
- ethelo::HELPER      Helper home id

_Win code:_
- 0:     Unknown
- 1:     Player1 winned
- 2:     Player2 winned
- 3:     Equalised

methods list:
```php
ethelo::helper($etheloTable, $forPlayer);       // load Helpers
ethelo::set($ehteloTable, $x, $y, $homeid);     // set a home
ethelo::get($etheloTable, $x, $y);              // get a home
ethelo::play($etheloTable, $x, $y, $player);    // select a home by Player (play) return boolean
ethelo::check($minroobTable);                   // return Win code
ethelo::sizex($etheloTable);                    // table Width
ethelo::sizey($etheloTable);                    // table Height
ethelo::playercount($etheloTable, $player);     // Player home selecteds count
ethelo::helpers($etheloTable);                  // helper homes
ethelo::bot($etheloTable, $player);             // run the game by robot as a player
ethelo::map($etheloTable, $emptyIcon, $Player1, $Player2, $helperIcon);     // Table to String
```

Helper methods:
```php
ethelo::helperPlay($etheloTable, $player);      // play and load Helpers for opponent
ethelo::helperMake($width = 8, $height = 8);    // make table and load Helpers for Player1
ethelo::helperBot($etheloTable, $player);       // play robot and load Heplers for opponent
```

`Good luck!`
