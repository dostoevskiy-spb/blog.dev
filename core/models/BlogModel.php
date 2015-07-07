<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 14:26
 * All rights are reserved
 */

namespace models;

use main\DateTimeHelper;

class BlogModel extends Model
{
    use DateTimeHelper;

    public $id;
    public $title;
    public $text;
    public $fulltext;
    public $date;
    public $comments;

    protected $_table = 'posts';

    public function getPosts()
    {
        $select = "SELECT id, title, text, date FROM {$this->_table} ORDER BY date DESC";
        if (!$sth = $this->getDbConnector()->query($select)) {
            throw new \Exception(var_dump($this->getDbConnector()->getErrorCode()));
        }

        return $sth->fetchAll();
    }


    public function insertPost()
    {
        $insert = "INSERT INTO {$this->_table} (`title`, `text`, `fulltext`, `date`) VALUES (:title, :text, :fulltext, :date)";
        $sth    = $this->getDbConnector()->prepare($insert);
        $sth->bindParam(':title', $this->title, \PDO::PARAM_STR, 150);
        $sth->bindParam(':text', $this->text, \PDO::PARAM_STR, 500);
        $sth->bindParam(':fulltext', $this->fulltext, \PDO::PARAM_STR);
        $date =  $this->getDateTime();
        $sth->bindParam(':date',$date);
        return $sth->execute();
    }

    public function updatePost()
    {
        $update = "UPDATE {$this->_table} SET `title`=:title, `text`=:text, `fulltext`=:fulltext WHERE id=:id";
        $sth    = $this->getDbConnector()->prepare($update);
        $sth->bindParam(':id', $this->id, \PDO::PARAM_INT, 150);
        $sth->bindParam(':title', $this->title, \PDO::PARAM_STR, 150);
        $sth->bindParam(':text', $this->text, \PDO::PARAM_STR, 500);
        $sth->bindParam(':fulltext', $this->fulltext, \PDO::PARAM_STR);

        return $sth->execute() ? $this : $sth->errorInfo();
    }

    public function addComment($data)
    {
        $comment = new CommentModel();

        $insert   = "INSERT INTO {$comment->getTableName()} (name, text, date, post_id) VALUES (:name, :text, :date, :post_id)";
        $sth      = $this->getDbConnector()->prepare($insert);
        $dateTime = $this->getDateTime();
        $sth->bindParam(':date', $dateTime);
        $sth->bindParam(':name', $data['name'], \PDO::PARAM_STR, 50);
        $sth->bindParam(':text', $data['text'], \PDO::PARAM_STR, 500);
        $sth->bindParam(':post_id', $this->id, \PDO::PARAM_INT);

        return $sth->execute();
    }

    public function getPost($id)
    {
        $select = "SELECT * FROM {$this->_table} WHERE id=:id";
        $sth    = $this->getDbConnector()->prepare($select);
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $post = $sth->fetch();
        if ($post) {
            $this->id       = $post['id'];
            $this->title    = $post['title'];
            $this->text     = $post['text'];
            $this->fulltext = $post['fulltext'];
            $this->date     = $post['date'];
            $postComments   = (new CommentModel())->getPostComments($id);
            $this->comments = $postComments ? $postComments : [];

            return $this;
        }

        return $post;

    }

    public function deletePost()
    {
        $delete = "DELETE FROM {$this->_table} WHERE id=:id";
        $sth    = $this->getDbConnector()->prepare($delete);
        $sth->bindParam(':id', $this->id, \PDO::PARAM_INT, 100);

        return $sth->execute();
    }


    public function getLastCreated()
    {
        $select = "SELECT * FROM {$this->_table} ORDER BY id DESC LIMIT 1";
        $sth    = $this->getDbConnector()->prepare($select);
        $sth->execute();
        $post = $sth->fetch();

        if ($post) {
            $this->id       = $post['id'];
            $this->title    = $post['title'];
            $this->text     = $post['text'];
            $this->fulltext = $post['fulltext'];
            $this->date     = $post['date'];

            return $this;
        }

        return FALSE;

    }
}