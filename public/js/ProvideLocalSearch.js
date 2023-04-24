/**
 * Обеспечение локального поиска продуктов по названию.
 */
export default class ProvideLocalSearch {
    _searchInputId

    _searchInput
    _query

    /**
     * Инициализировать логику локального поиска продуктов по названию.
     * @param searchInputId Идентификатор поля ввода строки запроса.
     * @param productsSelection Экземпляр выборки продуктов.
     */
    constructor(searchInputId, productsSelection) {
        this._searchInputId = searchInputId
        this.productsSelection = productsSelection

        this._onChangeSearchInput = this._onChangeSearchInput.bind(this)
    }

    /**
     * Обеспечить работу логики локального поиска продуктов.
     */
    provide() {
        this._searchInput = document.getElementById(this._searchInputId)
        this._setUpInputChanging()
    }

    _setUpInputChanging() {
        this._searchInput.addEventListener("input", this._onChangeSearchInput);
    }

    _onChangeSearchInput(event) {
        this._query = event.target.value
        const products = this._chooseProductsByQuery()
        this.productsSelection.setSelection(products)
    }

    _chooseProductsByQuery() {
        return this.productsSelection.getAll().filter(
            (product) => product['name'].lastIndexOf(this._query) !== -1
        )
    }
}