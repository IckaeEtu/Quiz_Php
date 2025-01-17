<?php

$dbFile = "quizz.db";

try {
    // Connexion à la base de donnée (ça la crée si elle n'existe pas)
    $db = new PDO("sqlite:" . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    echo "<h1>Bonjour, veuillez sélectionner votre fichier</h1>";
    echo "
    <form method='post' enctype='multipart/form-data'>
        <label for='quizFile'>Importez un fichier pour le quiz :</label><br>
        <input type='file' name='quizFile' id='quizFile' accept='.json,.txt' required><br><br>
        <button type='submit' name='action' value='upload'>Importer le fichier</button>
    </form>";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'upload') {
        if (isset($_FILES['quizFile']) && $_FILES['quizFile']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $_FILES['quizFile'];
            
            // Chemin temporaire du fichier uploadé
            $tmpFilePath = $uploadedFile['tmp_name'];
            
            // Vérifiez le type et contenu du fichier si nécessaire
            echo "Fichier importé avec succès : " . htmlspecialchars($uploadedFile['name']) . "<br>";
            echo "Taille du fichier : " . $uploadedFile['size'] . " octets.<br>";
    
            // Traitement du fichier (par exemple, lecture JSON ou validation)
            // Exemple de lecture du contenu si JSON :
            $fileContent = file_get_contents($tmpFilePath);
            $data = json_decode($fileContent, true);
    
            if ($data) {
                echo "Le contenu du fichier JSON a été chargé avec succès !<br>";
                // Exemple de traitement des données importées
                print_r($data);
                // Insertion des données
                foreach ($data as $quiz) {
                    // Insertion dans la table Quizz
                    $stmtQuiz = $db->prepare("INSERT INTO Quizz (Nom) VALUES (:nom)");
                    $stmtQuiz->execute(['nom' => $quiz['quiz_name']]);
                    $quizId = $db->lastInsertId();

                    foreach ($quiz['questions'] as $question) {
                        // Insertion des questions avec Id_Quizz associé
                        $stmtQuestion = $db->prepare("
                            INSERT INTO Questions (Nom, Type, Reponses, Reponse_Correcte, Score, Id_Quizz)
                            VALUES (:nom, :type, :reponses, :reponse_correcte, :score, :id_quizz)
                        ");
                        $stmtQuestion->execute([
                            'nom' => $question['name'],
                            'type' => $question['type'],
                            'reponses' => $question['reponses'],
                            'reponse_correcte' => $question['reponse_correcte'],
                            'score' => $question['score'],
                            'id_quizz' => $quizId,
                        ]);
                    }
                }
            } else {
                echo "Erreur : Le fichier n'est pas un JSON valide.<br>";
            }
        } else {
            echo "Erreur lors de l'importation du fichier.";
        }
    }
    }catch (PDOException $e) {
        die("Erreur lors de la création de la base de données : " . $e->getMessage());
    }
    
?>