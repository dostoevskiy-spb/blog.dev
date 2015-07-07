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

class CommentModel extends Model
{
    use DateTimeHelper;

    public $id;
    public $name;
    public $text;
    public $date;

    protected $_table = 'comments';

    public function getPostComments($id)
    {
        $select = "SELECT id, name, text, date FROM {$this->_table} WHERE post_id=:post_id ORDER BY date DESC";
        $sth    = $this->getDbConnector()->prepare($select);
        $sth->bindParam(':post_id', $id, \PDO::PARAM_INT);
        $sth->execute();

        $result = [];
        foreach ($sth->fetchAll() as $comment) {
            $temp       = new self;
            $temp->id   = $comment['id'];
            $temp->name = $comment['name'];
            $temp->text = $comment['text'];
            $temp->date = $comment['date'];
            $result[]   = $temp;
        }

        return $result;
    }

    public function getComment($id)
    {
        $select = "SELECT * FROM {$this->_table} WHERE id=:id";
        $sth    = $this->getDbConnector()->prepare($select);
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $com = $sth->fetch();
        if ($com) {
            $this->id   = $com['id'];
            $this->name = $com['name'];
            $this->text = $com['text'];
            $this->date = $com['date'];
        }


        return $com ? $this : FALSE;
    }


    public function deleteComment()
    {
        $delete = "DELETE FROM {$this->_table} WHERE id=:id";
        $sth    = $this->getDbConnector()->prepare($delete);
        $sth->bindParam(':id', $this->id, \PDO::PARAM_INT, 100);

        return $sth->execute();
    }

}