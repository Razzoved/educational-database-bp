<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- START OF PAGE SPLIT --->
<div class="page">

<!-- All tags -->
<div class="page-sidebar">
    <?= view('sidebar_buttons', ['properties' => $material->getGroupedProperties()]) ?>
</div>

<!-- Post container -->
<div class="page-content">

    <!-- Post top view: img, header -->
    <div class="row g-0">

        <!-- img -->
        <?= isset($material->referTo) ? "<a href='$material->referTo'>" : "" ?>
        <img class="col-sm-12 col-md-2 img-fluid rounded" src="<?= $material->getThumbnail()->getPath() ?>" style="max-height: 15rem; object-fit: scale-down" alt="Missing image">
        <?= isset($material->referTo) ? "</a>" : "" ?>

        <!-- header: title, date, views, rating -->
        <header class="col p-2" style="display: flex; flex-direction: column">

            <!-- title, goBack -->
            <div class="row g-0">
                <div class="col" style="max-width: 80%; word-wrap: break-word"><h1><?= $material->title ?></h1></div>
                <div class="col-auto d-none d-lg-block ms-auto"><button type='button' onclick="history.go(-1)" class="btn btn-dark">Go back</button></div>
            </div>

            <!-- date -->
            <p class="row p-1 text-muted"><small><?= $material->createdToDate() ?></small></p>

            <!-- rating, views -->
            <?= view('rating', ['material' => $material]) ?>

        </header>
    </div>

    <!-- SMALL SCREEN -->
    <div>
    <span class="row g-0 d-md-block d-lg-none mt-2">
        <a class="btn btn-dark"
           data-bs-toggle="offcanvas"
           href="#offcanvasSidebar"
           aria-controls="offcanvasSidebar">
           Show all tags
        </a>
    </span>
    <span class="row g-0 d-md-block d-lg-none mt-2">
        <a href='/' class="btn btn-dark">Go back</a>
        </a>
    </span>
    </div>

    <hr>

    <!-- Content -->
    <div class="p-2">
        <pre style="white-space: pre-line; font-family: Sans-serif, arial, monospace; font-size: 1rem">
            <?= $material->content ?>
        </pre>
    </div>

    <!-- Links -->
    <?= view_cell('App\Libraries\Material::listLinks', ['material' => $material]) ?>

    <!-- Downloadable -->
    <?= view_cell('App\Libraries\Material::listFiles', ['material' => $material]) ?>

    <!-- Related -->
    <?= view_cell('App\Libraries\Material::listRelated', ['material' => $material]) ?>

    <hr>
</div>
</div>
<!-- END OF PAGE SPLIT -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript">
    function rating_rate(element) {

    }

    function rating_mouseover(element) {

    }
</script>
<?= $this->endSection() ?>
