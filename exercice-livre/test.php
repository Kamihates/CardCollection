<?php

require_once("connexion.php"); // me permet de récupérer ma connexion

if ($_POST) {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $release_year = $_POST["release_year"];
    $available = $_POST["available"];

    try {
        $stmt = $pdo->prepare("INSERT INTO livres (title, author, release_year, available)
        VALUES (:title, :author, :release_year, :available)");

        $stmt->execute([
            "title" => $title,
            "author" => $author,
            "release_year" => $release_year,
            "available" => $available,
        ]);

        echo "Le livre a bien été ajouté !<br><br>";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM livres WHERE id = :id");

        $stmt->execute([
            "id" => $id,
        ]);

        echo "Le livre a bien été supprimé !<br><br>";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


$stmt = $pdo->query("SELECT * FROM livres WHERE YEAR(release_year) >= 2000 ORDER BY author"); // PDO STATEMENT
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Mes livres en BDD</h1>

    <table border="1">
        <thead>
          <th>Titre</th>
          <th>Auteur</th>
          <th>Date de sortie</th>
          <th>Disponible</th>
          <th>Action</th>
        </thead>

        <tbody>

            <?php

            foreach ($books as $key => $book) {
                echo "<tr>";

                    echo "<td>" . $book["title"] . "</td>";
                    echo "<td>" . $book["author"] . "</td>";
                    echo "<td>" . $book["release_year"] . "</td>";
                    echo "<td>" . ($book["available"] ? "yes" : "no") . "</td>";
                    echo "<td> <a href='?id=". $book["id"]. "&action=delete'>Supprimer</a></td>";
                echo "</tr>";
            }

            ?>

        </tbody>
    </table>

    <br>
    <br>

    <form method="POST" >
      <label for="title">Titre:</label>
      <input type="text" name="title" id="title" placeholder="Titre">

      <label for="author">Auteur:</label>
      <input type="text" name="author" id="author" placeholder="Auteur">

      <label for="release_year">Date de sortie:</label>
      <input type="date" name="release_year" id="release_year">

      <label for="available">Disponible :</label>
      <select name="available" id="available">
        <option value="1">Oui</option>
        <option value="0">Non</option>
      </select>

      <input type="submit" value="Ajouter livre">

    </form>

</body>
</html>
