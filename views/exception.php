<?php
return function (Throwable $throwable, bool $debug = true) {
    $pre = '';
    if ($debug and method_exists($throwable, 'toArray')) {
        $pre = print_r($throwable->toArray(false), true);
    }
    ?>
    <div class="row">
        <div class="col text-center">
            <h1>Exception <?= $throwable->getCode() ?></h1>
            <h2><?= $throwable->getMessage() ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-auto mx-auto text-left">
            <pre>
                <?= $pre ?>
            </pre>
        </div>
    </div>
    <?php
}
?>