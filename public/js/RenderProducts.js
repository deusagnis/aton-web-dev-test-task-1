export default class RenderProducts {

    _tableBodyId

    _tableBody
    _productCounter

    constructor(tableBodyId) {
        this._tableBodyId = tableBodyId

        this.render = this.render.bind(this)
    }

    render(products) {
        this._tableBody = document.getElementById(this._tableBodyId)
        this._tableBody.innerHTML = ""

        this._productCounter = 1
        products.forEach((product) => {
            const tableTr = document.createElement('tr')
            tableTr.insertAdjacentHTML(
                'beforeend',
                '<td class="align-middle">' + this._productCounter + '</td>'
            )
            tableTr.insertAdjacentHTML(
                'beforeend',
                '<td class="align-middle">' + product['id'] + '</td>'
            )
            tableTr.insertAdjacentHTML(
                'beforeend',
                '<td class="align-middle text-dark">' + product['name'] + '</td>'
            )
            tableTr.insertAdjacentHTML(
                'beforeend',
                '<td class="align-middle text-info">' + product['price'] + '</td>'
            )
            tableTr.insertAdjacentHTML(
                'beforeend',
                '<td class="align-middle">' + this._formatUnixDate(product['created_at']) + '</td>'
            )

            this._tableBody.appendChild(tableTr)
            this._productCounter++
        })
    }

    _formatUnixDate(unix) {
        return (new Date(Number(unix) * 1000)).toLocaleString()
    }
}