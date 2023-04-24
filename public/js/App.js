import RenderProducts from "./RenderProducts.js";
import ParseProductsResponse from "./ParseProductsResponse.js";
import ProvideLocalSearch from "./ProvideLocalSearch.js";
import ProductsSelection from "./ProductsSelection.js";
import ProductsPageState from "./ProductsPageState.js";
import ProvideGlobalSearch from "./ProvideGlobalSearch.js";
import ProvidePagination from "./ProvidePagination.js";
import ProvideLocalPriceSorting from "./ProvideLocalPriceSorting.js";
import ProvideCurrentSelectionCounter from "./ProvideCurrentSelectionCounter.js";

/**
 * Класс, соствляющий логику работы страницы из описанных кейсов.
 */
export default class App {
    /**
     * Запустить приложение.
     */
    run() {
        const pageState = new ProductsPageState(
            'serverOffsetInput',
            'globalSearchInput',
            'priceSortingSelect',
            'countSelect'
        )
        pageState.parse(true)

        const productsResponse = ParseProductsResponse.parse()

        const productsRendering = new RenderProducts('productsTableBody')

        const productSelectionCounter = new ProvideCurrentSelectionCounter('productsSelectionCounter')
        productSelectionCounter.provide()

        const productsSelection = new ProductsSelection()

        const localPriceSorting = new ProvideLocalPriceSorting('tablePriceSortBy', productsSelection)
        localPriceSorting.provide()

        productsSelection.addCallback(localPriceSorting.sortProducts)
        productsSelection.addCallback(productSelectionCounter.renderSelectionCounter)
        productsSelection.addCallback(productsRendering.render)
        productsSelection.setAllProducts(productsResponse['items'])

        const localSearch = new ProvideLocalSearch(
            'localSearchInput',
            productsSelection
        )
        localSearch.provide()

        const globalSearch = new ProvideGlobalSearch('globalSearchForm', pageState)
        globalSearch.provide()

        const pagination = new ProvidePagination('productsPagination', pageState, productsResponse['count'])
        pagination.provide()
    }
}