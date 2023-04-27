/**
 * Обеспечение логики глобального поиска продуктов.
 */
export default class ProvideGlobalSearch {
    _globalSearchFormId
    _pageState

    _globalSearchForm

    /**
     * Инициализировать работу логики глобального поиска.
     * @param globalSearchFormId Идентификатор формы, содержащей контроллер отправления данных глобального поиска (submit).
     * @param pageState Экземпляр состояния приложения.
     */
    constructor(globalSearchFormId, pageState) {
        this._globalSearchFormId = globalSearchFormId
        this._pageState = pageState

        this._onGlobalSearchSubmit = this._onGlobalSearchSubmit.bind(this)
    }

    /**
     * Обеспечить работу глобального поиска продуктов.
     */
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