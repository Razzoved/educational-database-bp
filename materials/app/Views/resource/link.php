<!-- group of MATERIALS shown as clickable links -->
<?php if (isset($resources) && $resources !== []) : ?>
<h2><?= $title ?></h5>
<ul class="links">
    <?php foreach ($resources as $resource) : ?>
    <li class="links__item">
        <?php if (!$resource->isLink()) : ?>
        <img class="links__thumbnail" src="<?= \App\Libraries\Resource::pathToFileURL($resource->getRootPath()) ?>"></img>
        <a class="links__href" href="<?= $resource->getURL() ?>" download>
        <?php else : ?>
        <a class="links__href" target="_blank" href="<?= $resource->getURL() ?>">
        <?php endif; ?>
        <?= $resource->isLink() ? $resource->path : basename($resource->path) ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
