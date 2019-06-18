<?php

require_once __DIR__ . "/../../layout/header.php";
require_once __DIR__ . "/../../../model/database.php";


$projects = getAllRows("project");

?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Créer un membre</h1>
</div>

    <form method="post" action="create-query.php">
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="firstname" class="form-control" placeholder="Prénom" required>
            <label>Nom</label>
            <input type="text" name="lastname" class="form-control" placeholder="Nom" required>
            <label>Portrait</label>
            <input type="file" name="picture" class="form-control">
            <label>Projet</label>
            <select name="project_ids[]" multiple class="form-control">
                <?php foreach ($projects as $project) : ?>
                    <option value="<?= $project["id"]; ?>">
                        <?= $project["title"]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i>
            Ajouter
        </button>
    </form>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>