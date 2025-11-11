<?php
for ($i = 1; $i <= 10; $i++) {
    for ($j = 1; $j <= 10; $j++) {
        echo str_pad($i * $j, 4, " ", STR_PAD_LEFT);
    }
    echo PHP_EOL;
}
?>