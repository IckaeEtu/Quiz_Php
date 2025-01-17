<?php
spl_autoload_register(static function(string $fqcn) {
    // $fqcn contient Model\Thread\Message par exemple
    // remplaçons les \ par des / et ajoutons .php à la fin.
    // on obtient Model/Thread/Message.php

    // echo "Trying to load class: " . $fqcn;
    // echo PHP_EOL;
    
    $path = str_replace('\\', '/', $fqcn).'.php';
 
    // puis chargeons le fichier
    require_once($path);
});
?>