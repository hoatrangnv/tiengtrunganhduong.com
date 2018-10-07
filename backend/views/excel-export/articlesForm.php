<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/7/2018
 * Time: 12:33 PM
 */

$article = new \backend\models\Article();
?>
<form id="export-form">

    <input type="number" name="page_size" placeholder="page_size: 0 means unlimited" value="0">

    <input type="number" name="page_index" placeholder="page_index: start from 0" value="0">

    <h3>Select fields to export:</h3>
    <?php
    foreach ($article->attributes() as $attr) {
        ?>
        <label>
            <input type="checkbox" name="fields[]" value="<?= $attr ?>">
            <span><?= $article->getAttributeLabel($attr) ?></span>
        </label>
        <?php
    }
    ?>

    <h3>Sorts:</h3>
    <ul>
        <?php
        foreach ($article->attributes() as $attr) {
            ?>
            <li>
                <span><?= $article->getAttributeLabel($attr) ?>:</span>
                <select class="sort-input" name="sort-<?= $attr ?>" data-attr="<?= $attr ?>">
                    <option value=""></option>
                    <option value="+">Ascending</option>
                    <option value="-">Descending</option>
                </select>
            </li>
            <?php
        }
        ?>
    </ul>

    <button type="submit">Get Download Link</button>

    <div id="result"></div>
</form>

<script>
    var form = document.getElementById('export-form');
    form.onsubmit = function (event) {
        event.preventDefault();

        var $fields = form.querySelectorAll('[name="fields[]"]');
        var fv_fields = [].filter.call($fields, function ($field) {
            return $field.checked;
        }).map(function ($field) {
            return $field.value;
        }).join('|');
        
        var $page_size = form.querySelector('[name="page_size"]');
        var fv_page_size = $page_size.value;
        
        var $page_index = form.querySelector('[name="page_index"]');
        var fv_page_index = $page_index.value;
        
        var $sorts = form.querySelectorAll('.sort-input');
        var fv_sort = [].filter.call($sorts, function ($sort) {
            return $sort.value !== '';
        }).map(function ($sort) {
            return ($sort.value === '-' ? '-' : '') + $sort.dataset['attr'];
        }).join('|');

        var fd = new FormData();
        fd.append('fields', fv_fields);
        fd.append('page_size', fv_page_size);
        fd.append('page_index', fv_page_index);
        fd.append('sort', fv_sort);
        fd.append('<?= Yii::$app->request->csrfParam ?>', '<?= Yii::$app->request->csrfToken ?>');

        var xhr = new XMLHttpRequest();

        $submit = form.querySelector('button[type="submit"]');
        $submit.disabled = true;
        $submit.innerHTML = 'Processing...';

        var $result = form.querySelector('#result');

        xhr.onload = function () {
            $result.innerHTML = xhr.responseText;
            $submit.disabled = false;
            $submit.innerHTML = 'Get Download Link';
        };

        xhr.onerror = function () {
            $result.innerHTML = 'Error: ' + xhr.responseText;
            $submit.disabled = false;
            $submit.innerHTML = 'Get Download Link';
        };

        xhr.open('GET', '<?= \yii\helpers\Url::to(['excel-export/articles']) ?>?'
            + ['fields=' + fv_fields,
                'sort=' + fv_sort,
                'page_size=' + fv_page_size,
                'page_index=' + fv_page_index
            ].join('&'));
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(fd);
    };
</script>