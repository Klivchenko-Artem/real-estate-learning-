/**
 * @see https://prettier.io/docs/configuration
 * @type {import("prettier").Config}
 */

const config = {
	printWidth: 120,
	useTabs: true,
	semi: true,
	singleQuote: false,
	jsxSingleQuote: false,
	trailingComma: "es5",
	arrowParens: "always",
	bracketSpacing: true,
	quoteProps: "as-needed",
	proseWrap: "preserve",
	htmlWhitespaceSensitivity: "css",
	vueIndentScriptAndStyle: false,
	endOfLine: "lf",
	singleAttributePerLine: true,
	bracketSameLine: false,
	embeddedLanguageFormatting: "auto",
	insertPragma: false,
	requirePragma: false,
};

export default config;
