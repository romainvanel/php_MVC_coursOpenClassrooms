<?php

namespace Application\Controllers\ModifyComment;

require_once('src/lib/database.php');
require_once('src/model/comment.php');

use Application\Model\Comment\CommentRepository;
use Application\Lib\Database\DatabaseConnection;


class ModifyComment
{
    public function execute(string $identifier, ?array $input)
    {
        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection;
        $comment = $commentRepository->getComment($identifier);

        require('templates/modifyComment.php');

        $author = null;
        $comment = null;
        if (!empty($input['author']) && !empty($input['comment'])) {
            $author = $input['author'];
            $comment = $input['comment'];
        } else {
            throw new \Exception('Les données du formulaire sont invalides');
        }

        $success = $commentRepository->modifyComment($author, $comment, $identifier);
        if(!$success) {
            throw new \Exception('Impossible de modifier le commentaire ! ');
        } else {
            header('Location: index.php?action=modifyComment&id='.$identifier);
        }
    } 
}