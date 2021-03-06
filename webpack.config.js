const path = require('path');

module.exports = {
	mode: 'development',
	entry: ['./assets/js/src/functions.js', './assets/css/scss/fanoe.scss'],
	output: {
		path: path.resolve(__dirname, 'assets/js'),
		filename: 'bundle.js',
	},
	module: {
		rules: [
			/**
			 * Running Babel on JS files.
			 */
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['env']
					}
				}
			},
			{
				test: /\.scss$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: '[name].css',
							outputPath: path.resolve(__dirname, 'assets/css')
						}
					},
					{
						loader: 'extract-loader'
					},
					{
						loader: 'css-loader?-url'
					},
					{
						loader: 'postcss-loader'
					},
					{
						loader: 'sass-loader'
					}
				]
			}
		]
	}
};
