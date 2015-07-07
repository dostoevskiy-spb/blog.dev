<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 20:31
 * All rights are reserved
 */
?>
<div class="post">
    <h2 class="title"><?= $post->title ?></h2>

    <p class="meta">
        <span class="date"><?= (new DateTime($post->date))->format('d.m.Y') ?></span></p>

    <div style="clear: both;">&nbsp;</div>
    <div class="entry">
        <?= $post->text ?>
        <br/>
        <?= $post->fulltext ?>
        <p class="links"><a href="/blog" class="more">Назад</a></p>
    </div>
</div>
<hr style="width: 620px">
<div class="comments">
    <? foreach ($post->comments as $comment) { ?>

        <div class="comment">
            <p><span class="name"><?= $comment->name ?></span></p>

            <div class="entry">
                <?= $comment->text ?>
                <p class="links">
                    <? if (\main\App::isAuthorized()) { ?>
                        <a href="/blog/delete_comment/<?= $comment->id ?>" class="more">Удалить</a>
                    <? } ?>
                </p>
            </div>
            <p class="meta"><span class="date"><?= (new DateTime($comment->date))->format('d.m.Y') ?></span></p>
        </div>
        <hr style="width: 620px">
    <? } ?>
</div>
<div class="TTWForm-container">
    <div id="form-title" class="form-title field">
        <h2> Оставьте ваш комментарий </h2>
    </div>
    <form action="/blog/add_comment/<?= $post->id ?>" class="TTWForm" method="post" novalidate="" style="width: 500px;">
        <div id="field1-container" class="field f_100">
            <label for="field1"> Ваше имя </label>
            <input type="text" name="name" id="field1" required="required">
        </div>
        <div id="field2-container" class="field f_100">
            <label for="field2"> Комментарий </label>
            <textarea rows="5" cols="20" name="text" id="field2" required="required"></textarea>
        </div>
        <div id="form-submit" class="field f_100 clearfix submit">
            <input type="submit" value="Оставить комментарий">
        </div>
    </form>
</div>