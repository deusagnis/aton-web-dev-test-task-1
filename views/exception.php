<?php
return function (Throwable $throwable, bool $debug = true) {
    $pre = '';
    if (method_exists($throwable, 'toArray')) {
        $pre = ($debug) ? print_r($throwable->toArray(false), true) : '';
        $message = $throwable->getMessage();
    }else{
        $message = ($debug) ? $throwable->getMessage() : 'Unexpected error :(';
    }

    ?>
    <div class="row">
        <div class="col text-center">
            <h1>Exception <?= $throwable->getCode() ?></h1>
            <h2><?= $message ?></h2>
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