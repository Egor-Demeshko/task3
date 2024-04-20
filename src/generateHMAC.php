<?php

$arg = array_slice($argv, 1);

echo hash("sha3-256", (trim($arg[0]) . trim($arg[1])));
