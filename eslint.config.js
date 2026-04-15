// @ts-check

import globals from "globals";
import eslint from "@eslint/js";
import tsEslint from "typescript-eslint";
import pluginVue from "eslint-plugin-vue";
import vueParser from "vue-eslint-parser";
import eslintConfigPrettier from "eslint-plugin-prettier/recommended";

export default tsEslint.config(
	eslint.configs.recommended,
	...tsEslint.configs.recommended,
	...pluginVue.configs["flat/recommended"],
	eslintConfigPrettier,

	{
		files: ["**/*.vue", "**/*.js", "**/*.jsx", "**/*.cjs", "**/*.mjs", "**/*.ts", "**/*.tsx", "**/*.cts", "**/*.mts"],
		plugins: {
			"@typescript-eslint": tsEslint.plugin,
			vue: pluginVue,
		},
		languageOptions: {
			globals: { ...globals.browser, ym: "readonly" },
			parser: vueParser,
			parserOptions: {
				parser: tsEslint.parser,
			},
			ecmaVersion: "latest",
			sourceType: "module",
		},
		rules: {
			"vue/attributes-order": [
				"warn",
				{
					order: [
						"DEFINITION",
						"LIST_RENDERING",
						"CONDITIONALS",
						"RENDER_MODIFIERS",
						"GLOBAL",
						["UNIQUE", "SLOT"],
						"TWO_WAY_BINDING",
						"OTHER_DIRECTIVES",
						"OTHER_ATTR",
						"EVENTS",
						"CONTENT",
					],
					alphabetical: false,
				},
			],
			"vue/require-default-prop": "off",
			"vue/no-v-html": "off",

			// TypeScript
			quotes: ["warn", "double", { avoidEscape: true }],
		},
	}
);
