<?php
require 'autoloader.php';


use Form\Type\Text;
use Form\Type\Checkbox;
use Form\Type\Number;

error_reporting(E_ALL);
ini_set("display_errors", 1);

echo new Text('azeazeazeaze').PHP_EOL;
echo new Checkbox('check moi ça la rafale',false,'Checked');
echo new Number('ja');

function chargerQuestionnaire(): void{
    
}

?>
