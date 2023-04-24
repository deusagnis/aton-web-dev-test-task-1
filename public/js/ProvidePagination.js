export default class ProvidePagination {
    paginationPageClass = 'paginationPage'
    minPage = 1
    pageBandwidth = 3

    _paginationId
    _pageState
    _totalCount

    _currentPage
    _maxPage

    constructor(paginationId, pageState, totalCount) {
        this._paginationId = paginationId
        this._pageState = pageState
        this._totalCount = totalCount

        this._onClickPage = this._onClickPage.bind(this)
    }

    provide() {
        this._calcCurrentPage()
        this._calcMaxPage()
        this._renderPagination()
        this._setUpCallbacks()
    }

    _renderPagination() {
        if (this._maxPage === this.minPage) return
        let paginationPlace = document.getElementById(this._paginationId)
        paginationPlace.innerHTML = ''

        paginationPlace.insertAdjacentHTML(
            'beforeend',
            this._createPageItem(this.minPage, '<<', false)
        )
        for (let i = this._currentPage - this.pageBandwidth; i <= this._maxPage; i++) {
            if (i < this.minPage) continue

            if (i === this._currentPage) {
                paginationPlace.insertAdjacentHTML('beforeend',
                    this._createPageItem(i, i, true)
                )
            } else {
                paginationPlace.insertAdjacentHTML(
                    'beforeend',
                    this._createPageItem(i, i, false)
                )
            }
        }
        paginationPlace.insertAdjacentHTML(
            'beforeend',
            this._createPageItem(this._maxPage, '>>', false)
        )
    }

    _createPageItem(page, name, active = false) {
        let html = ''
        if (active) {
            html += '<li class="page-item active" aria-current="page"><span class="page-link"'
        } else {
            html += '<li class="page-item"><a href="#" class="page-link ' + this.paginationPageClass + '"'
        }

        html += ' data-page="' + page + '">' + name
        html += (active) ? '</span>' : '</a>'
        html += '</li>'

        return html
    }

    _setUpCallbacks() {
        const pages = document.getElementsByClassName(this.paginationPageClass)
        for (const page of pages) {
            page.addEventListener('click', this._onClickPage)
        }
    }

    _onClickPage(event) {
        event.preventDefault()
        const page = event.target.getAttribute('data-page')
        const newOffset = this._calcNewOffset(page)

        this._pageState.setOffset(newOffset)
        location.href = '?' + this._pageState.genQuery()
    }

    _calcNewOffset(page) {
        return (Number(page) - 1) * Number(this._pageState.getCount())
    }

    _calcCurrentPage() {
        this._currentPage = Math.floor(Number(this._pageState.getOffset()) / Number(this._pageState.getCount())) + 1
    }

    _calcMaxPage() {
        this._maxPage = Math.ceil(this._totalCount / Number(this._pageState.getCount()))
        if (this._maxPage === 0) this._maxPage++
    }
}