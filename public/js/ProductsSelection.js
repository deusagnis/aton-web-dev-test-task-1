/**
 * Управление выдачей выборок продуктов.
 *
 * Логика работы приложения подразумевает создание выборок продуктов.
 * При этом необходимо контролировать событие изменения выборки и иметь доступ
 * к акутальной выборке из различных частей приложения.
 */
export default class ProductsSelection {
    _productsChangedCallbacks = []
    _allProducts = null
    _productsSelection = null

    /**
     * Добавить callback, который будет вызван при изменении текущей выборки продуктов.
     * @param callback
     */
    addCallback(callback) {
        this._productsChangedCallbacks.push(callback)
    }

    /**
     * Установить список всех найденных продуктов.
     * @param products Массив всех доступных продуктов.
     */
    setAllProducts(products) {
        this._allProducts = [...products]

        this.setSelection(products)
    }

    /**
     * Устнановить текущую выборку.
     * @param products
     */
    setSelection(products) {
        this._productsSelection = products

        this._onProductsChange()
    }

    /**
     * Получить текущую выборку.
     * @returns {*[]} Массив продуктов в текущей выборке.
     */
    getSelection() {
        return this._productsSelection
    }

    /**
     * Получить список всех доступных продуктов.
     * @returns {*[]}
     */
    getAll() {
        return this._allProducts
    }

    /**
     * Сбросить текущую выборку, заменив всеми доступными продуктами.
     */
    reset() {
        this.setAllProducts(this.getAll())
    }

    /**
     * Обновить текущую выборку.
     */
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