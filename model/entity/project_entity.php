<?php

function getAllProjects(int $id = null, int $limit = 0) {
    global $connection;

    $query = "
        SELECT
            project.*,
            DATE_FORMAT(project.date_start, '%d/%m/%Y') AS date_start_format,
            category.label AS category,
            COUNT(phm.member_id) AS nb_members
        FROM project
        INNER JOIN category ON project.category_id = category.id
        LEFT JOIN project_has_member AS phm ON project.id = phm.project_id
    ";

    // Si l'identifiant d'un projet est défini, on ajoute une clause WHERE
    if ($id != null) {
        $query .= " WHERE project.id = $id";
    }

    $query .= " GROUP BY project.id
                ORDER BY project.date_start DESC";

    // Si la limite du nombre de lignes est supérieur à zéro, on ajoute une clause LIMIT
    if ($limit > 0) {
        $query .= " LIMIT $limit";
    }

    $stmt = $connection->prepare($query);
    $stmt->execute();

    // Si la requête ne retourne qu'une seule ligne, la fonction renvoie uniquement cette ligne
    if ($id != null || $limit == 1) {
        return $stmt->fetch();
    } else {
        return $stmt->fetchAll();
    }
}

function getAllMembersByProject(int $id) : array {
    global $connection;

    $query = "
        SELECT *
        FROM member
        INNER JOIN project_has_member AS phm ON member.id = phm.member_id
        WHERE phm.project_id = :id
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    return $stmt->fetchAll();
}

function getAllProjectsByCategory(int $id) : array {
    global $connection;

    $query = "
        SELECT
            project.*,
            DATE_FORMAT(project.date_start, '%d/%m/%Y') AS date_start_format,
            category.label AS category,
            COUNT(phm.member_id) AS nb_members
        FROM project
        INNER JOIN category ON project.category_id = category.id
        LEFT JOIN project_has_member AS phm ON project.id = phm.project_id
        WHERE category.id = :id
        GROUP BY project.id
        ORDER BY project.date_start DESC
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    return $stmt->fetchAll();
}

function searchProjects(string $search, ?int $categoryId) : array {
    global $connection;

    $query = "
        SELECT
            project.*,
            DATE_FORMAT(project.date_start, '%d/%m/%Y') AS date_start_format,
            category.label AS category,
            COUNT(phm.member_id) AS nb_members,
            MATCH(project.title, project.description) AGAINST ('$search') AS score
        FROM project
        INNER JOIN category ON project.category_id = category.id
        LEFT JOIN project_has_member AS phm ON project.id = phm.project_id
        WHERE 1 = 1
    ";

    if ($search != "") {
        $query .= " AND (project.title LIKE '%$search%' OR project.description LIKE '%$search%')";
    }

    if ($categoryId != null) {
        $query .= " AND category.id = $categoryId";
    }

    $query .= " GROUP BY project.id
                ORDER BY score DESC
    ";

    $stmt = $connection->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll();
}

function insertProject($title, $picture, $description, $price, $dateStart, $dateEnd, $categoryId, $memberIds) {
    global $connection;

    $query = "
        INSERT INTO project (title, picture, description, price, date_start, date_end, category_id)
        VALUES (:title, :picture, :description, :price, :date_start, :date_end, :category_id)
    ";

    $dateStart = ($dateStart == "") ? null : $dateStart;
    $dateEnd = ($dateEnd == "") ? null : $dateEnd;

    $stmt = $connection->prepare($query);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":picture", $picture);
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":price", $price);
    $stmt->bindParam(":date_start", $dateStart);
    $stmt->bindParam(":date_end", $dateEnd);
    $stmt->bindParam(":category_id", $categoryId);
    $stmt->execute();

    $projectId = $connection->lastInsertId();

    foreach ($memberIds as $memberId) {
        insertProjectHasMember($projectId, $memberId);
    }
}

function insertProjectHasMember(int $projectId, int $memberId) {
    global $connection;

    $query = "
        INSERT INTO project_has_member (project_id, member_id)
        VALUES (:project_id, :member_id)
    ";

    $stmt = $connection->prepare($query);
    $stmt->bindParam(":project_id", $projectId);
    $stmt->bindParam(":member_id", $memberId);
    $stmt->execute();
}
