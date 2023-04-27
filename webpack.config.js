resolve = require('path').resolve

module.exports = {
    entry: ['./public/js/src/index.js'],
    output: {
        filename: 'app.js',
        path: resolve('./public/js/dist'),
    },
};