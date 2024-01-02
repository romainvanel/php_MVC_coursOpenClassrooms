<?php

namespace Application\Model\Comment;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Comment 
{
    public int $id;
    public string $author;
    public string $frenchCreationDate;
    public string $comment;
}

class CommentRepository
{
    public DatabaseConnection $connection;

    public function getComments(string $post): array 
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
        );
        $statement->execute([$post]);
    
        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->id = $row['id'];
            $comment->author = $row['author'];
            $comment->comment = $row['comment'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comments[] = $comment;
        }
    
        return $comments;
    }

    public function getComment(string $commentId): Comment
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM comments WHERE id = ?"
        );
        $statement->execute([$commentId]);

        $row = $statement->fetch();
        $comment = new Comment();
        $comment->id = $row['id'];
        $comment->author = $row['author'];
        $comment->comment = $row['comment'];
        $comment->frenchCreationDate = $row['french_creation_date'];

        return $comment;
    } 
    
    public function createComment(string $post, string $author, string $comment): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO comments(post_id, author, comment, comment_date) VALUES (?, ?, ?, NOW())"
        );
        $affectedLines = $statement->execute([$post, $author, $comment]);
    
        return ($affectedLines > 0);
    }

    public function modifyComment(string $author, string $comment, string $commentId,): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE comments SET author = ?, comment = ?, comment_date = NOW() WHERE id = ?"
        );
        $affectedLines = $statement->execute([$author, $comment, $commentId,]);

        return ($affectedLines > 0);
    }
    
}
