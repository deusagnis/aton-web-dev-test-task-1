<?php
return function (array $products) {
    // TODO: Create products view
    ?>
    <div class="container">
        <div class="row">
            <div class="col-auto mx-auto">
                <pre>
                    <?= print_r($products, true) ?>
                </pre>
            </div>
        </div>
    </div>
    <?php
}
?>