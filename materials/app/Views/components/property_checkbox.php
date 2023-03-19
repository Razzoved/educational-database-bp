<?php
    /**
     * Shows all items as clicakble checkboxes. On next search all
     * checked checkboxes are used for filtering.
     */
?>

<input class="filter" type="checkbox"
    name="<?= esc($tag) ?>[<?= esc($value) ?>]"
    id="<?= esc($tag) ?>[<?= esc($value) ?>]">
</input>
<label for="<?= esc($tag) ?>[<?= esc($value) ?>]">
        <?= esc($value) ?>
</label>
