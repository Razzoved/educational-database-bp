<?php
    /**
     * Template for displaying material as a row in administration.
     * May be deleted by a javascript function deleteId!
     *
     * @var \App\Entities\Material $material object of material entity class
     */

    use App\Entities\Cast\StatusCast;

    $class = 'item' . ($material->status === StatusCast::PUBLIC ? '' : ' private');
    $view = url_to('Material::get', $material->id);
    $edit = url_to('Admin\MaterialEditor::get', $material->id);
?>
<article id="<?= $material->id ?>" class="<?= $class ?>">
    <div class="item__header">
        <img class="item__logo"
            src="<?= $material->getThumbnail()->getURL() ?>"
            alt="missing_img">
        <div class="item__controls">
            <a class="item__preview" target="_self" rel="noreferrer" href="<?= $view ?>">
                View
            </a>
            <a class="item__edit" href="<?= $edit ?>">
                Edit
            </a>
            <button class="item__delete" type="button" onclick="deleteOpen(<?= $material->id ?>)">
                &#10005;
            </button>
        </div>
    </div>
    <section>
        <h2 class="item__title"><?= $material->title?></h2>
        <div class="item__row">
            <p class="item__text">
                <small>ID:</small><br>
                <strong><?= $material->id ?></strong>
            </p>
            <p class="item__text">
                <small>Views:</small><br><?= $material->views ?>
            </p>
            <p class="item__text">
                <small>Published:</small><br><?= $material->publishedToDate() ?>
            </p>
        </div>
        <div class="item__row">
            <p class="item__text">
                <small>Status:</small><br><?= $material->status ?>
            </p>
            <p class="item__text">
                <small>Rating:</small><br><?= $material->rating ?><?= $material->rating_count > 0 ? "&nbsp;&nbsp;<u style='opacity: .5; font-size: 75%;'>{$material->rating_count}x</u>" : "" ?>
            </p>
            <p class="item__text">
                <small>Updated:</small><br><?= $material->updatedToDate() ?>
            </p>
        </div>
    </section>
</article>
