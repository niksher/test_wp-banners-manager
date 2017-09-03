<?php

?>

<a 
    class="koran-banners__link koran-banners__add-banner" 
    href="<?= $_SERVER["REQUEST_URI"] . "&status=add" ?>"
>
    Добавить баннер
</a>
<div class="koran-banners-list">
    <div class="koran-banners-list__item">
        <div class="koran-banners-list__col koran-banners-list__item-id">
            ID
        </div>
        <div class="koran-banners-list__col koran-banners-list__item-name">
            Title
        </div>
        <div 
            class="koran-banners-list__col koran-banners-list__item-edit" 
            
        >
            
        </div>
    </div>
    <?PHP FOREACH ($banners as $banner) : ?>
        <div class="koran-banners-list__item">
            <div class="koran-banners-list__col koran-banners-list__item-id">
                <?= $banner->id ?>
            </div>
            <div class="koran-banners-list__col koran-banners-list__item-name">
                <?= $banner->title ?>
            </div>
            <a 
                class="koran-banners-list__col koran-banners-list__item-edit" 
                href="<?= $_SERVER["REQUEST_URI"] . "&status=edit&id=" . $banner->id ?>"
            >
                Редактировать
            </a>
        </div>
    <?PHP ENDFOREACH ?>
</div>

<?PHP IF (count($banners) > 0) : ?>
<a 
    class="koran-banners__link koran-banners__generate-json"
    href="<?= $_SERVER["REQUEST_URI"] . "&status=generate" ?>"
>
    Создать JSON
</a>
<?PHP ENDIF ?>

<?PHP IF ($json) : ?>
<br>
<a 
    class="koran-banners__link koran-banners__generate-json"
    href="/wp-content/plugins/koranBanners/out.json"
    target="_blank"
>
    Посмотреть JSON
</a>
<?PHP ENDIF ?>

