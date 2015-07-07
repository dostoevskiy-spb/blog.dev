<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 02.04.14
 * Time: 21:48
 * All rights are reserved
 */
?>

<div class="TTWForm-container">


    <div id="form-title" class="form-title field">
        <h2>
            Новая запись
        </h2>
    </div>


    <form action="/blog/create" class="TTWForm ui-sortable-disabled" method="post"
          novalidate="">


        <div id="field1-container" class="field f_100 ui-resizable-disabled ui-state-disabled">
            <label for="field1">
                Заголовок
            </label>
            <input type="text" name="title" id="field1" required="required"/>
        </div>


        <div id="field2-container" class="field f_100 ui-resizable-disabled ui-state-disabled">
            <label for="field2">
                Анонс
            </label>
            <textarea rows="5" cols="20" name="text" id="field2" required="required"></textarea>
        </div>


        <div id="field3-container" class="field f_100 ui-resizable-disabled ui-state-disabled">
            <label for="field3">
                Полный текст записи
            </label>
            <textarea rows="5" cols="20" name="fulltext" id="field3" required="required"></textarea>
        </div>


        <div id="form-submit" class="field f_100 clearfix submit">
            <input type="submit" value="Сохранить">
        </div>
    </form>
</div>