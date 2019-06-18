<?php


function insertMember ($firstname, $lastname, $picture, $projectIds) {
    global $connection;

    $query = "
        INSERT INTO member (firstname, lastname, picture)
        VALUES (:firstname, :lastname, :picture)
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":picture", $picture);

    return $stmt->execute();

    $projectId = $connection->lastInsertId();

    foreach ($projectIds as $projectId) {
        insertProjectHasMember($memberId, $projectId);
}

}