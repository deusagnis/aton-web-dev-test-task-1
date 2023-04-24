export default class ProvideCurrentSelectionCounter {

    _productsSelectionCounterId
    _counterSpan

    constructor(productsSelectionCounterId) {
        this._productsSelectionCounterId = productsSelectionCounterId

        this.renderSelectionCounter = this.renderSelectionCounter.bind(this)
    }
    provide() {
        this._counterSpan = document.getElementById(this._productsSelectionCounterId)
    }

    renderSelectionCounter(products){
        this._counterSpan.innerText = products.length
    }
}