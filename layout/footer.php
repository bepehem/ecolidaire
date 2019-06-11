<?php
require_once __DIR__ . "/../model/database.php";
$categories = getAllRows("category");
?>
</main>

<footer class="site-footer">
    <div class="container">
        Copyright <?= date('Y'); ?> Ecolidaire
    </div>
    <div>
        <form method="post" action="insert-category.php">
            <input type="text" name="label" placeholder="Catégorie">
            <input type="submit">
        </form>
    </div>
    <div>
        <?php foreach ($categories as $cat) : ?>
            <a href="category.php?id=<?= $cat["id"]; ?>">
                <?= $cat["label"]; ?>
            </a>
        <?php endforeach; ?>
    </div>
</footer>

</body>
</html>