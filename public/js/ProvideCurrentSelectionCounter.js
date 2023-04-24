/**
 * Обеспечение работы счетчика продуктов в текущей выборке.
 */
export default class ProvideCurrentSelectionCounter {

    _productsSelectionCounterId
    _counterSpan

    /**
     * Инициализировать работу счетчика продуктов.
     * @param productsSelectionCounterId Идентификатор счетчика продуктов текущей выборки.
     */
    constructor(productsSelectionCounterId) {
        this._productsSelectionCounterId = productsSelectionCounterId

        this.renderSelectionCounter = this.renderSelectionCounter.bind(this)
    }

    /**
     * Обеспечить работу подсчета продуктов в текущей выборке.
     */
    provide() {
        this._counterSpan = document.getElementById(this._productsSelectionCounterId)
    }

    /**
     * Callback, обновляющий значение счетчика продуктов в текущей выборке.
     * @param products Массив продуктов текущей выборки.
     */
    renderSelectionCounter(products) {
        this._counterSpan.innerText = products.length
    }
}