<?php
require_once __DIR__ . "/../../../model/database.php";

$categories = getAllRows("category");

require_once __DIR__ . "/../../layout/header.php";
?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Gestion des categories</h1>
    </div>

    <a href="create-form.php" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Ajouter
    </a>

    <hr>


    <table class="table table-striped table-bordered">
        <thead class="thead-light">
        <tr>
            <th>Libellé</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?= $category["label"]; ?></td>
                <td class="actions">
                    <div class="d-flex justify-content-around">
                    <a href="update-form.php?id=<?= $category["id"]; ?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                        Modifier
                    </a>

                    <form method="post" action="delete-query.php">
                        <input type="hidden" name="id" value="<?= $category["id"]; ?>">
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