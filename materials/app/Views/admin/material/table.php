<?= $this->extend('layouts/admin') ?>

<?= $this->section('header') ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form method="post" action="<?= base_url('admin/materials/1') ?>">
<div class="page">
    <div class="page-sidebar">
        <h1><?= $title ?></h1>
        <?= view('sidebar_checkboxes', ['properties' => $filters]) ?>
    </div>

    <main class="page-content">
        <h1><?= $title ?></h1>
        <div class="page-controls">
            <input name="search" value="" placeholder="Search"/>
            <button type="submit">Search</button>
        </div>
        <div class="page-controls">
            <button type="button" onclick="toggleSort('id')"><i class="fa-solid <?= isset($_POST['sort']) && $_POST['sort'] === 'id' ? ($_POST['sortDir'] === 'DESC' ? 'fa-caret-up' : 'fa-caret-down') : 'fa-caret-right' ?>"></i> ID</button>
            <button type="button" onclick="toggleSort('title')"><i class="fa-solid <?= isset($_POST['sort']) && $_POST['sort'] === 'title' ? ($_POST['sortDir'] === 'DESC' ? 'fa-caret-up' : 'fa-caret-down') : 'fa-caret-right' ?>"></i> Title</button>
            <button type="button" onclick="toggleSort('created_at')"><i class="fa-solid <?= isset($_POST['sort']) && $_POST['sort'] === 'created_at' ? ($_POST['sortDir'] === 'DESC' ? 'fa-caret-up' : 'fa-caret-down') : 'fa-caret-right' ?>"></i> Created At</button>
            <button type="button" onclick="toggleSort('updated_at')"><i class="fa-solid <?= isset($_POST['sort']) && $_POST['sort'] === 'updated_at' ? ($_POST['sortDir'] === 'DESC' ? 'fa-caret-up' : 'fa-caret-down') : 'fa-caret-right' ?>"></i> Last Update</button>
            <button type="button" onclick="toggleSort('views')"><i class="fa-solid <?= isset($_POST['sort']) && $_POST['sort'] === 'views' ? ($_POST['sortDir'] === 'DESC' ? 'fa-caret-up' : 'fa-caret-down') : 'fa-caret-right' ?>"></i> Views</button>
            <button type="button" onclick="window.location.href='<?= base_url('admin/materials/edit') ?>'">&#65291</button>
        </div>

        <div class="table" id="items">
        <?php
            echo view_cell('\App\Libraries\Material::getRowTemplate');
            $index = 0;
            foreach($materials as $material) {
                echo view_cell('\App\Libraries\Material::toRow', ['material' => $material, 'index' => $index++]);
            }
            ?>
        </div>

        <?= $pager->links('default', 'full') ?>
    </main>
</div>
</form>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<?= view('admin/delete', ['action' => base_url('admin/materials/delete')]) ?>
<?= $this->endSection() ?>
