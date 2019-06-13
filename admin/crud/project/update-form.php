<?php
require_once __DIR__ . "/../../../model/database.php";

$id =$_GET["id"];
$category =getOneRow("category", $id);

require_once __DIR__ . "/../../layout/header.php"; ?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Modifier une catégorie</h1>
    </div>

    <form method="post" action="update-query.php">
        <div class="form-group">
            <label>Libellé</label>
            <input type="text" name="label" maxlength="255" value="<?= htmlspecialchars($category["label"]); ?>" class="form-control" placeholder="Libellé" required>
        </div>
        <input type="hidden" name="id" value="<?= $category["id"]; ?>">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i>
            Modifier
        </button>
    </form>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>