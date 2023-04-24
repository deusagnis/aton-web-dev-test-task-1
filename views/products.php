<?php
return function (int $productsCount, $offset, $count, $query, $sortBy) {
    ?>
    <div class="row mx-auto">
        <div class="col col-md-7 mx-auto text-center">
            <h3>Товары</h3>
        </div>
    </div>
    <div class="row mx-auto">
        <div class="col col-md-7 mx-auto">
            <form class="input-group mb-1" id="globalSearchForm">
                <input hidden type="number" value="<?= $offset ?>" id="serverOffsetInput">
                <input type="text" class="form-control rounded-start-2" placeholder="Глобальный поиск"
                       aria-label="Глобальный поиск"
                       value="<?= $query ?? '' ?>"
                       aria-describedby="globalSearchButton" id="globalSearchInput">
                <button type="submit" class="btn btn-outline-secondary">🔍︎</button>
            </form>
        </div>
    </div>
    <div class="row mx-auto">
        <div class="col col-md-7 mx-auto">
            <div class="row mb-2">
                <div class="col">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Цена:</span>
                        <select class="form-select" id="priceSortingSelect">
                            <option <?= $sortBy === null ? 'selected' : '' ?> value="0">без сортировки</option>
                            <option <?= $sortBy['price'] === 'asc' ? 'selected' : '' ?>
                                value="asc">сначала дешевле
                            </option>
                            <option <?= $sortBy['price'] === 'desc' ? 'selected' : '' ?>
                                value="desc">сначала дороже
                            </option>
                        </select>
                    </div>
                </div>
                <div class="w-100 d-block d-md-none"></div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Показывать по:</span>
                        <select class="form-select" id="countSelect">
                            <option <?= $count === 10 ? 'selected' : '' ?> value="10">10</option>
                            <option <?= $count === 15 ? 'selected' : '' ?> value="15">15</option>
                            <option <?= $count === 25 ? 'selected' : '' ?> value="25">25</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mx-auto">
        <div class="col col-md-7 mx-auto">
            <div class="row py-1">
                <div class="col">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="Локальный поиск"
                               aria-label="Локальный поиск" id="localSearchInput">
                    </div>
                </div>
                <div class="col align-self-center">
                    <div class="text-end ">
                        Всего: <span class="fw-bold"><?= $productsCount ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mx-auto">
        <div class="col col-md-7 mx-auto overflow-x-auto">
            <table class="table table-bordered text-center overflow-auto mb-2">
                <thead>
                <tr>
                    <th class="align-middle">#</th>
                    <th class="align-middle">ID</th>
                    <th class="align-middle">Название товара</th>
                    <th class="align-middle">
                        <select class="btn btn-light border-dark fw-bold px-2 py-1" id="tablePriceSortBy" style="appearance: none">
                            <option value="0">Цена</option>
                            <option value="asc">Цена ↑</option>
                            <option value="desc">Цена ↓</option>
                        </select>
                    </th>
                    <th class="align-middle">Добавлен</th>
                </tr>
                </thead>
                <tbody id="productsTableBody">

                </tbody>
            </table>
        </div>
    </div>
    <div class="row mx-auto">
        <div class="col-auto mx-auto">
            <nav aria-label="Products pagination">
                <ul class="pagination" id="productsPagination">
                </ul>
            </nav>
        </div>
    </div>
    <?php
}
?>