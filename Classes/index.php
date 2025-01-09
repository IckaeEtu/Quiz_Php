<?php
    require_once 'autoloader.php';

    use Form\Type\Radio;

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $json = file_get_contents("../data/model.json");
    $data = json_decode($json, true);
    echo "<form method='POST' action='reponse.php'>";
    if (!file_exists('Form/Type/Radio.php')) {
        die('Le fichier Radio.php est introuvable');
    }

    foreach ($data as $key => $value) {
        echo "attetion ça commence";
        if ($value['type'])
        $radio = new Radio("oui",$value["label"],$value["choices"],$value["correct"]);
        echo $radio->render();
        echo "c'est fait";
    
    }
    
    echo "<input type='submit' value='Soumettre'>";
    echo "</form>";
?>