<?php
    function findpfp($dir){
        $files = scandir($dir);
        foreach ($files as $i)
            if (Str::startsWith($i, 'pfp'))
                return $i;
    }

    function getFirstAtt($path){
        return scandir($path)[2];
    }
?>
