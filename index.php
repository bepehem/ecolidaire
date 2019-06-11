<?php

require_once  __DIR__ ."/model/database.php";

$projects = getAllProjects(0, 3);
$categories = getAllRows("category");

require_once __DIR__ ."/layout/header.php";


?>
        <header class="home-banner">
            <h1>Bienvenue sur <strong>Ecolidaire</strong></h1>
            <p>Let's go Green!
            <form method="get" action="search.php">
                <input type="search" name="search" placeholder="Rechercher...">
                <select name="category_id">
                    <option value="">Toutes les categories</option>
                <?php foreach($categories as $cat) : ?>
                    <option value="<?= $cat["id"]; ?>"><?= $cat["label"]; ?></option>
                <?php endforeach; ?>
                </select>
                <input type="submit">
            </form>
        </header>

        <section class="container">
            <h2>Nos dernières actions</h2>

            <div class="actions">

                <?php foreach($projects as $project) : ?>

                    <?php include "include/project_inc.php"; ?>

                <?php endforeach; ?>

            </div>
        </section>
    </main>

<?php require_once __DIR__ ."/layout/footer.php";

?>
