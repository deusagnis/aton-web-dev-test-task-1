export default class ProvideLocalSearch {
    _searchInputId

    _searchInput
    _query

    constructor(searchInputId, productsSelection) {
        this._searchInputId = searchInputId
        this.productsSelection = productsSelection

        this.onChangeSearchInput = this.onChangeSearchInput.bind(this)
    }

    provide() {
        this._searchInput = document.getElementById(this._searchInputId)
        this.setUpInputChanging()
    }

    setUpInputChanging() {
        this._searchInput.addEventListener("input", this.onChangeSearchInput);
    }

    onChangeSearchInput(event) {
        this._query = event.target.value
        const products = this.chooseProductsByQuery()
        this.productsSelection.setSelection(products)
    }

    chooseProductsByQuery() {
        return this.productsSelection.getAll().filter(
            (product) => product['name'].lastIndexOf(this._query) !== -1
        )
    }
}