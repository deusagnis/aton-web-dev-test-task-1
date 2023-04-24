/**
 * Обеспечить логику сортировки продуктов текущей выборки по цене.
 */
export default class ProvideLocalPriceSorting {
    _priceSortSelectId
    _productSelection

    _priceSortSelect
    _sortBy = '0'

    /**
     * Инициализировать логику локальной сортировки продуктов по цене.
     * @param priceSortSelectId
     * @param productsSelection
     */
    constructor(priceSortSelectId, productsSelection) {
        this._priceSortSelectId = priceSortSelectId
        this._productSelection = productsSelection

        this._onPriseSortSelectChange = this._onPriseSortSelectChange.bind(this)
        this.sortProducts = this.sortProducts.bind(this)
    }

    /**
     * Обеспечить работу логики локальной сортировки продуктов по цене.
     */
    provide() {
        this._priceSortSelect = document.getElementById(this._priceSortSelectId)
        this._priceSortSelect.addEventListener('change', this._onPriseSortSelectChange)
    }

    /**
     * Callback сортировки продуктов относительно типа сортировки.
     * @param products Массив продуктов.
     * @returns {*[]} Отсортированный массив продуктов.
     */
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