<?php
require_once __DIR__ . "/../../security.php";
require_once __DIR__ . "/../../../model/database.php";

// Récupérer les données du formulaire
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$filePicture = $_FILES["picture"];
$picture = $filePicture["name"];
$projectIds = $_POST["project_ids"];

move_uploaded_file($filePicture["tmp_name"], "../../../images/portraits/" . $filePicture["name"]);

// Envoyer les données à la base de données
updateMember($firstname, $lastname, $picture, $projectIds);

// Rediriger l'utilisateur
header("Location: index.php");