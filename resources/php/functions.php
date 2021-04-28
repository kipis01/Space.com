<?php
    function findpfp($dir){
        $files = scandir($dir);
        foreach ($files as $i)
            if (Str::startsWith($i, 'pfp'))
                return $i;
    }

    function getFirstAtt($path){
        $files = scandir("$path");
        foreach ($files as $i)
            if (Str::length($i) > 1 && $i[0] == '1')
                return $i;
    }
?>
