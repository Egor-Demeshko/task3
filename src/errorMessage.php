<?php
$entryError = str_replace("\t", "", "Only odd number of arguments is valid.
And greater than or equal 3.
For example: php index.php option1 option2 option3
or php index.php one two three four five.
Odd numbers are 3,5,7,9,11 etc.");


define("ENTRY_ERROR", $entryError);
