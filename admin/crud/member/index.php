<?php
require_once __DIR__ . "/../../../model/database.php";

$members = getAllRows("member");
$projects= getAllProjects();


require_once __DIR__ . "/../../layout/header.php";
?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Gestion des membres</h1>
    </div>

    <a href="create-form.php" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Ajouter
    </a>

    <hr>


    <table class="table table-striped table-bordered">
        <thead class="thead-light">
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Projets</th>
            <th>Photo</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($members as $member) : ?>
            <tr>
                <td><?= $member["firstname"]; ?></td>
                <td><?= $member["lastname"]; ?></td>
                <td><?= $project; ?></td>

                <td width="150px"><img src="../../../images/portraits/<?= $member["picture"]; ?>" height ="80px" width="90px" class="por-thumbnail" alt="por-thumbnail"></td>

                <td class="actions">
                    <div class="d-flex justify-content-around">
                    <a href="update-form.php?id=<?= $member["id"]; ?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                        Modifier
                    </a>

                    <form method="post" action="delete-query.php">
                        <input type="hidden" name="id" value="<?= $member["id"]; ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                            Supprimer
                        </button>
                    </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>