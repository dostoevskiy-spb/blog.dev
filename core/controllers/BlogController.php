<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 18:43
 * All rights are reserved
 */

//namespace controllers;

use main\Query;
use main\HttpException;
use models\BlogModel;
use controllers\Controller;

class BlogController extends Controller
{
    use Query;

    public function __construct()
    {
        $this->_model = new BlogModel();
    }

    public function actionIndex()
    {
        $posts = $this->_model->getPosts();
        $this->render('/blog/index', ['posts' => $posts]);
    }

    public function actionView($id)
    {
        $post = $this->getModel($id);
        $this->render('/blog/view', ['post' => $post]);
    }

    public function actionCreate()
    {
        if (!\main\App::isAuthorized())
            throw new HttpException('Нет прав для создания записи');
        if ($this->isPostRequest()) {
            $post           = new BlogModel();
            $post->title    = $this->getInput('title');
            $post->text     = $this->getInput('text');
            $post->fulltext = $this->getInput('fulltext');
            if ($post->insertPost()) {
                $last = $post->getLastCreated();
                if ($this->isAjax()) {
                    echo json_encode(['status' => 'success', 'redirect' => "/blog/view/$last->id"]);
                } else {
                    $this->redirect("/blog/view/{$last->id}");
                }
            } else {
                throw new HttpException('Не удалось создать запись');
            }
        } else {
            $this->render('/blog/create');
        }
    }

    public function  actionDelete($id)
    {
        if (!\main\App::isAuthorized())
            throw new HttpException('Нет прав для создания записи');
        /** @var BlogModel $post */
        $post = $this->getModel($id);
        $post->deletePost();
        $this->redirect('/');
    }

    public function  actionUpdate($id)
    {
        if (!\main\App::isAuthorized())
            throw new HttpException('Нет прав для создания записи');

        $post = $this->getModel($id);
        if ($this->isPostRequest()) {
            $post->title    = $this->getInput('title');
            $post->text     = $this->getInput('text');
            $post->fulltext = $this->getInput('fulltext');
            $post->updatePost();
            if ($this->isAjax()) {
                echo json_encode(['status' => 'success', 'redirect' => '/blog/view/' . $post->id]);
            } else {
                $this->redirect("/blog/view/$post->id");
            }
        } else {
            $this->render('/blog/update', ['post' => $post]);
        }
    }

    public function actionAdd_comment($id)
    {
        $postTrySelect = $this->_model->getPost($id);
        $post          = new BlogModel();
        $post->id      = $id;
        $data['name']  = $this->getInput('name');
        $data['text']  = $this->getInput('text');
        $post->addComment($data);
        if ($this->isAjax())
            echo json_encode(['status' => 'success', 'redirect' => '/blog/view/' . $post->id]);
        else
            $this->redirect("/blog/view/$id");
    }


    public function actionDelete_comment($id)
    {
        if (!\main\App::isAuthorized())
            throw new HttpException('Нет прав для создания записи');
        $comment = new \models\CommentModel();
        if (!$comment = $comment->getComment($id))
            throw new HttpException('Такого комментария не существует');
        if ($r = $comment->deleteComment())
            $this->redirect($this->getReferer());
        else
            throw new HttpException('Не удалось удалить комментарий');
    }


    /**
     * @param $id
     *
     * @return mixed
     * @throws main\HttpException
     */
    protected function getModel($id)
    {
        $post = $this->_model->getPost($id);
        if (!$post) {
            throw new HttpException('Такой записи не существует');
        }

        return $post;
    }
}