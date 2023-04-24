export default class ProvideLocalPriceSorting {
    _priceSortSelectId
    _productSelection

    _priceSortSelect
    _sortBy = '0'

    constructor(priceSortSelectId, productsSelection) {
        this._priceSortSelectId = priceSortSelectId
        this._productSelection = productsSelection

        this._onPriseSortSelectChange = this._onPriseSortSelectChange.bind(this)
        this.sortProducts = this.sortProducts.bind(this)
    }

    provide() {
        this._priceSortSelect = document.getElementById(this._priceSortSelectId)
        this._priceSortSelect.addEventListener('change', this._onPriseSortSelectChange)
    }

    sortProducts(products) {
        if (this._sortBy === '0') return products
        return [...products].sort((prod1, prod2) => {
            if (this._sortBy === 'asc') {
                return Number(prod1['price']) - Number(prod2['price'])
            } else {
                return Number(prod2['price']) - Number(prod1['price'])
            }
        })
    }

    _onPriseSortSelectChange(event) {
        this._sortBy = event.target.value
        this._productSelection.refresh()
    }
}