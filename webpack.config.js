const path = require('path')
const UglifyJSPlugin = require('uglifyjs-webpack-plugin')

module.exports = (env, argv) => {
    const dev = argv.mode === 'development';

    let cssLoaders = [
        'style-loader',
        {loader: 'css-loader', options: {importLoaders: 1}},
    ];

    if (!dev) {
        cssLoaders.push({
            loader: 'postcss-loader', options: {
                plugins: (loader) => [
                    require('autoprefixer')({
                        browsers: ['last 4 versions', 'ie > 8']
                    })
                ]
            }
        })
    }

    let config = {
        entry: './resources/js/index.js',
        watch: dev,
        output: {
            path: path.resolve(__dirname, 'public/assets/js'),
            filename: 'app.js',
            publicPath: '/assets/js'
        },
        devtool: dev ? "cheap-module-eval-source-map" : 'source-map',
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: ['babel-loader']
                },
                {
                    test: /\.css$/,
                    use: cssLoaders
                },
                {
                    test: /\.scss$/,
                    use: [
                        ...cssLoaders,
                        'sass-loader'
                    ]
                }
            ]
        },
        plugins: []
    }

    if (!dev) {
        config.plugins.push(new UglifyJSPlugin({
            sourceMap: true
        }))
    }

    return config
}
