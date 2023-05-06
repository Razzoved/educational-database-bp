<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="page">
    <h1 class="page__title"><?= $title ?></h1>

    <div class="page__sidebar">
        <?= view('property/filter_checkbox', ['properties' => $filters]) ?>
    </div>

    <div class="page__content">
        <div class="page__controls">
            <?= view('search_bar', ['action' => url_to('Admin\Material::index'), 'options' => $options]) ?>
            <?= view('sort_bar', [
                'sorters' => [
                    'ID',
                    'Title',
                    'Status',
                    'Views',
                    'Rating',
                    'Rating count',
                    'Published at',
                    'Updated at',
                ],
                'create' => "window.location.href='" . url_to('Admin\MaterialEditor::index') . "'"]) ?>
        </div>

        <div class="table" id="items">
        <?php
            if ($materials === []) {
                echo $this->include('none');
            } else foreach($materials as $material) {
                echo view('admin/material/item', ['material' => $material]);
            }
            ?>
        </div>

        <?= $pager->links('default', 'full') ?>
    </div>
</div>
</form>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<?= view('admin/delete', ['action' => url_to('Admin\MaterialEditor::delete', 0)]) ?>
<?= $this->endSection() ?>
