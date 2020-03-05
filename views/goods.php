<?php
/**@var \App\models\Good[] $goods */
/**@var string $title */
?>

<h2><?= $title ?></h2>
<a href="/?c=good&a=add">Добавить товар</a>
<?php foreach ($goods as $good) : ?>
    <p>Название товара <?= $good->getName() ?></p>
        <a href="?a=one&id=<?= $good->getId()?>">Подробнее</a>
<?php endforeach;?>