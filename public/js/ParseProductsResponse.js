export default class ParseProductsResponse {
    static parse(){
        return JSON.parse(FOUND_PRODUCTS_JSON ?? '{"count":0,"items":[]}');
    }
}