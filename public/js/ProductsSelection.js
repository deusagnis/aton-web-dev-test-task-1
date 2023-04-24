export default class ProductsSelection {
    _productsChangedCallbacks = []
    _allProducts = null
    _productsSelection = null

    addCallback(callback) {
        this._productsChangedCallbacks.push(callback)
    }

    setAllProducts(products) {
        this._allProducts = [...products]

        this.setSelection(products)
    }

    setSelection(products) {
        this._productsSelection = products

        this._onProductsChange()
    }

    getSelection() {
        return this._productsSelection
    }

    getAll() {
        return this._allProducts
    }

    reset() {
        this.setAllProducts(this.getAll())
    }

    refresh() {
        this.setSelection(this.getSelection())
    }

    _onProductsChange() {
        let mutableSelection = this.getSelection()
        for (let callback of this._productsChangedCallbacks) {
            const newSelection = callback(mutableSelection)
            if (Array.isArray(newSelection)) mutableSelection = newSelection
        }
    }
}