const path = require('path')
const UglifyJSPlugin = require('uglifyjs-webpack-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin')

module.exports = (env, argv) => {
    const dev = argv.mode === 'development';

    let cssLoaders = [
        {
            loader: 'css-loader',
            options: {
                importLoaders: 1,
                url: true,
                sourceMap: !dev
            }
        },
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
        entry: {
            app: './resources/js/index.js'
        },
        watch: dev,
        output: {
            path: path.resolve(__dirname, 'public/assets/'),
            filename: 'app.js',
            publicPath: '/assets/'
        },
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js/'),
                '@sass': path.resolve(__dirname, 'resources/sass/')
            }
        },
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: ['babel-loader']
                },
                {
                    test: /\.css$/,
                    use: ExtractTextPlugin.extract({
                        fallback: "style-loader",
                        use: cssLoaders
                    })
                },
                {
                    test: /\.scss$/,
                    use: ExtractTextPlugin.extract({
                        fallback: "style-loader",
                        use: [...cssLoaders, 'sass-loader']
                    })
                },
                {
                    test: /\.svg$/,
                    loader: 'svg-loader'
                },
                {
                    test: /\.(woff2?|eot|ttf|otf)/,
                    loader: 'file-loader'
                },
                {
                    test: /\.(png|jpe?g|gif|svg)$/,
                    use: [
                        {
                            loader: 'url-loader',
                            options: {
                                limit: 8192,
                                name: '[name].[ext]'
                            }
                        },
                        {
                            loader: 'img-loader',
                            options: {
                                enabled: !dev
                            }
                        }
                    ]
                },
            ]
        },
        plugins: [
            new ExtractTextPlugin({
                filename: '[name].css',
                disable: false
            })
        ]
    }

    if (!dev) {
        config.plugins.push(new UglifyJSPlugin({
            sourceMap: true
        }))

        config.plugins.push(new OptimizeCssAssetsPlugin({
            assetNameRegExp: /\.css$/g,
            cssProcessor: require('cssnano'),
            cssProcessorPluginOptions: {
                preset: ['default', { discardComments: { removeAll: true } }],
            },
            canPrint: true
        }))
    }

    return config
}
