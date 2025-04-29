<?php require '../vendor/autoload.php';

// Calcul de moyenne
 function CalculerMoyenne($note1, $note2, $note3)
 {
   return ($note1 + $note2 + $note3)/3;
 }

 function AfficherMoyenne($nom, $moyenne)
 {
   if($moyenne >= 10)
   {
     echo "Moyenne de $nom suffisante";
   }
   else
   {
     echo "Moyenne de $nom insuffisante";
   }
 }

 AfficherMoyenne("Elise", CalculerMoyenne(17,18,19));

echo "<br/>";
echo "<br/>";

// Calcul nombre carre

 function carre($nbCarre, $nb)
 {
   return $nbCarre * $nbCarre * $nb;
 }

echo "Carre : ", carre(3,2);
echo "<br/>";
echo "<br/>";

// Exo API OMDb
use GuzzleHttp\Client;

// Cle API
$client_id = 'd0e72d2e';

$client = new Client();

$movie_id = 'tt3896198';  // Utilise l'ID du film (gardien de la galaxie)

try {
    // Requête GET à l'OMDb API avec l'ID du film
    $url = "http://www.omdbapi.com/?i=$movie_id&apikey=$client_id";

    $response = $client->request('GET', $url);

    // Décoder la réponse JSON
    $data = json_decode($response->getBody(), true);

    // Vérifier si le film est trouvé
    if ($data['Response'] === 'True') {
        // Afficher les informations sur le film
        echo "Titre : " . $data['Title'] . "<br>";
        echo "Année : " . $data['Year'] . "<br>";
        echo "Genre : " . $data['Genre'] . "<br>";
        echo "Réalisateur : " . $data['Director'] . "<br>";
        echo "Acteurs : " . $data['Actors'] . "<br>";
        echo "Résumé : " . $data['Plot'] . "<br>";
    } else {
        echo "Film non trouvé. Erreur : " . $data['Error'] . "<br>";
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

?>
