<div class="page__group">
    <button type="button" class="page__toggler" onclick="toggleGroup(this)">
        <i class="fa fa-bars"></i>
        Toggle tags
    </button>
    <?php foreach ($properties as $tag => $values) : ?>
        <?= view('components/collapsible_list', ['tag' => $tag, 'values' => $values, 'type' => 'button']) ?>
    <?php endforeach; ?>
</div>
