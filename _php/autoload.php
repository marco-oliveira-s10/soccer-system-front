<?php
header('Content-Type: application/json');
spl_autoload_register(function ($nomeClasse) {    
    $arquivo = "$nomeClasse.php";    
    if (file_exists($arquivo)) {    
        require_once($arquivo);    
    } else {
        require_once('_classes' . DIRECTORY_SEPARATOR . $arquivo);
    }
});