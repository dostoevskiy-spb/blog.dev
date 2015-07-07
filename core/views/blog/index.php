<? foreach ($posts as $post) { ?>
    <div class="post">
        <h2 class="title"><a href="/blog/view/<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>

        <p class="meta">
            <span class="date"><?= (new DateTime($post['date']))->format('d.m.Y') ?></span></p>

        <div style="clear: both;">&nbsp;</div>
        <div class="entry">
            <?= $post['text'] ?>
            <p class="links">
                <a href="/blog/view/<?= $post['id'] ?>" class="more">Читать дальше</a>
                <? if (\main\App::isAuthorized()) { ?>
                    <a href="/blog/update/<?= $post['id'] ?>" class="more">Редактировать</a>
                    <a href="/blog/delete/<?= $post['id'] ?>" class="more">Удалить</a>
                <? } ?>
            </p>
        </div>
    </div>
<? } ?>