/**
 * Хранилище состояния приложения.
 * Состояние содержит параметры поиска продуктов, которые могут менятьтся
 * по мере работы приложения.
 */
export default class ProductsPageState {
    _serverOffsetInputId
    _globalSearchInputId
    _priceSortingSelectId
    _countSelectId

    _serverOffsetInput
    _globalSearchInput
    _priceSortingSelect
    _countSelect

    _count = 15
    _offset = 0
    _sortBy = null
    _query = null

    _initialParse
    _needResetOffset = false

    /**
     * Инициализировать состояние приложения.
     * @param serverOffsetInputId Идентификатор скрытого поля, хранящего использованный сервером offset.
     * @param globalSearchInputId Идентификатор поля ввода запроса для глобального поиска продуктов по названию.
     * @param priceSortingSelectId Идентификатор списка выбора сортировки цены при глобальном поиске.
     * @param countSelectId Идентификатор списка выбора количества продуктов на странице.
     */
    constructor(serverOffsetInputId, globalSearchInputId, priceSortingSelectId, countSelectId) {
        this._serverOffsetInputId = serverOffsetInputId
        this._globalSearchInputId = globalSearchInputId
        this._priceSortingSelectId = priceSortingSelectId
        this._countSelectId = countSelectId
    }

    /**
     * Спарсить со страницы данные состояние приложения.
     * @param initialParse Флаг первичного определения состояния.
     */
    parse(initialParse = false) {
        this._initialParse = initialParse
        this._findElements()
        this._parseElementsValues()
        this._correctOffset()
    }

    /**
     * Сгенерировать строку запроса к странице с текущим состоянием.
     * @returns {string}
     */
    genQuery() {
        const params = new URLSearchParams(this._genQueryState());
        return params.toString();
    }

    /**
     * Установить значения offset для поиска продуктов.
     * @param offset Отступ при поиске продуктов.
     */
    setOffset(offset) {
        this._offset = offset
    }

    /**
     * Получить текущее количество продуктов, отображаемых на странице.
     * @returns {number}
     */
    getCount() {
        return this._count
    }

    /**
     * Получить текущий отсуп поиска продуктов.
     * @returns {number} Текущий отступ поиска продуктов.
     */
    getOffset() {
        return this._offset
    }

    _genQueryState() {
        const queryState = {
            count: String(this._count),
            offset: String(this._offset)
        }
        if (this._sortBy !== null) {
            queryState['sortBy[price]'] = this._sortBy['price']
        }
        if (this._query !== null) {
            queryState['q'] = this._query
        }
        return queryState
    }

    _findElements() {
        this._serverOffsetInput = document.getElementById(this._serverOffsetInputId)
        this._globalSearchInput = document.getElementById(this._globalSearchInputId)
        this._priceSortingSelect = document.getElementById(this._priceSortingSelectId)
        this._countSelect = document.getElementById(this._countSelectId)
    }

    _parseElementsValues() {
        const newCount = Number(this._countSelect.value)
        if (this._count !== newCount) {
            this._needResetOffset = true
            this._count = newCount
        }

        this._offset = Number(this._serverOffsetInput.value)

        const priceSorting = this._priceSortingSelect.value
        if (priceSorting === 'asc') {
            this._sortBy = {price: 'asc'}
        } else if (priceSorting === 'desc') {
            this._sortBy = {price: 'desc'}
        } else {
            this._sortBy = null
        }

        let newQuery = this._globalSearchInput.value
        newQuery = (newQuery.length > 0) ? newQuery : null
        if (this._query !== newQuery) {
            this._query = newQuery
            this._needResetOffset = true
        }
    }

    _correctOffset() {
        this._needResetOffset = this._needResetOffset && !this._initialParse
        if (this._needResetOffset) {
            this._offset = 0
            this._needResetOffset = false
        }
    }
}