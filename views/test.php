<?php
return function (string $s, int $b, string $summandPropName) {
    $b += $this->{$summandPropName} ?? 0;
    ?>
    <div><?= $s ?> = <?= $b ?></div>
    <?php
};