<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page">

    <main class="page-content">
        <h1><?= $title ?></h1>

        <div id="items">
        <?php
            foreach($materials as $material) {
                echo view('components/material_as_card', ['material' => $material]);
            }
            if ($materials === []) {
                echo '<hr style="margin-top: 1rem; margin-bottom: 1rem">';
                echo '<h2 style="text-align:center">None were found.</h2>';
            }
        ?>
        </div>
    </main>

</div>
<?= $this->endSection() ?>
