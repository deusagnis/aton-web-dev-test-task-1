import App from "./App.js";

/**
 * Запуск приложения по окончании загрузки страницы.
 */
window.addEventListener("load", () => {
    const app = new App()
    app.run()
});