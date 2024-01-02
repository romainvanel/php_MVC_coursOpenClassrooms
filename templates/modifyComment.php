<?php $title = "Edit du commentaire"; ?>

<?php ob_start(); ?>
<form action="index.php?action=modifyComment&id=<?= $comment->id ?>" method="post">
        <div>
            <label for="author">Auteur</label><br />
            <input type="text" id="author" name="author" value="<?= $comment->author ?>"/>
        </div>
        <div>
            <label for="comment">Commentaire</label><br />
            <textarea id="comment" name="comment"><?= $comment->comment ?></textarea>
        </div>
        <div>
            <input type="submit" />
        </div>
    </form>
    <?php $content = ob_get_clean(); ?>

<?php require('layout.php');
