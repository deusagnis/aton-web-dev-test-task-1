export default class ProvideGlobalSearch {
    _globalSearchFormId
    _pageState

    _globalSearchForm

    constructor(globalSearchFormId, pageState) {
        this._globalSearchFormId = globalSearchFormId
        this._pageState = pageState

        this._onGlobalSearchSubmit = this._onGlobalSearchSubmit.bind(this)
    }

    provide() {
        this._globalSearchForm = document.getElementById(this._globalSearchFormId)
        this._globalSearchForm.addEventListener('submit', this._onGlobalSearchSubmit)
    }

    _onGlobalSearchSubmit(event) {
        event.preventDefault()

        this._pageState.parse()
        location.href = '?' + this._pageState.genQuery()
    }
}