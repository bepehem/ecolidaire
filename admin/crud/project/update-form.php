<?php
require_once __DIR__ . "/../../../model/database.php";

$id = $_GET["id"];
$project = getOneRow("project", $id);
$categories = getAllRows("category");
$members = getAllRows("member");

$projectMembers = getAllMembersByProject($id);
$projectMembersIds = [];
foreach($projectMembers as $projectMember){
    $projectMembersIds [] = $projectMember ["id"];
}

require_once __DIR__ . "/../../layout/header.php"; ?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Modifier un projet</h1>
    </div>

    <form method="post" action="update-query.php" enctype="multipart/form-data">
        <div class="form-group">
            <label>Titre</label>
            <input type="text" name="title" value="<?= $project["title"]; ?>" class="form-control" placeholder="Titre" required>
        </div>
        <div class="form-group">
            <label>Catégorie</label>
            <select name="category_id" class="form-control">

                <?php foreach ($categories as $category) :?><?php $selected = ($category["id"] == $project["category_id"]) ? "selected" : ""; ?>
                    <option value="<?= $category["id"]; ?>"<?= $selected; ?>>
                        <?= $category["label"]; ?>
                    </option>
                <?php endforeach; ?>


            </select>
        </div>
        <div class="form-group">
            <label>Image</label><br>
            <img src="../../../images/<?= $project["picture"]; ?>" class="img-thumbnail" alt="img-thumbnail">
            <input type="file" name="picture" value="<?= $project["picture"]; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= $project["description"]; ?></textarea>
        </div>
        <div class="form-group">
            <label>Prix</label>
            <input type="number" name="price" value="<?= $project["price"]; ?>" class="form-control" placeholder="Prix" required>
        </div>
        <div class="form-group">
            <label>Date de début</label>
            <input type="date" name="date_start" value="<?= $project["date_start"]; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Date de fin</label>
            <input type="date" name="date_end" value="<?= $project["date_end"]; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label>Membres</label>
            <select name="member_ids[]" multiple class="form-control">
                <?php foreach ($members as $member) : ?>
                    <?php $selected = (in_array($member["id"], $projectMembersIds)) ? "selected" : ""; ?>
                    <option value="<?= $member["id"]; ?>"<?= $selected; ?>>
                        <?= $member["firstname"] . " " . $member["lastname"]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="hidden" name="id" value="<?= $project["id"]; ?>">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i>
            Ajouter
        </button>
    </form>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>