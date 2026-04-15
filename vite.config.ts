import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import svgLoader from "vite-svg-loader";
import { viteStaticCopy } from "vite-plugin-static-copy";

import path from "node:path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default defineConfig({
	define: {
		__VUE_PROD_HYDRATION_MISMATCH_DETAILS__: "true",
	},
	plugins: [
		vue({
			template: {
				transformAssetUrls: {
					base: null,
					includeAbsolute: false,
				},
			},
		}),
		svgLoader({
			svgoConfig: {
				plugins: [
					{
						name: "preset-default",
						params: {
							overrides: {
								removeViewBox: false,
							},
						},
					},
				],
			},
		}),
		laravel({
			buildDirectory: "app/client",
			input: ["resources/client/app.ts"],
			ssr: "resources/client/ssr.ts",
			refresh: true,
		}),
		viteStaticCopy({
			targets: [
				{
					src: "./resources/client/assets/static",
					dest: "./assets",
				},
				{
					src: "./resources/client/assets/images",
					dest: "./assets",
				},
				{
					src: "./resources/client/assets/videos",
					dest: "./assets",
				},
			],
		}),
	],
	resolve: {
		alias: {
			"@": path.join(__dirname, "/resources/client"),
			"~": path.join(__dirname, "/node_modules"),
		},
	},
	ssr: {
		noExternal: ["lodash", "vue-yandex-maps", /\.css$/, /\?vue&type=style/],
	},
	css: {
		preprocessorOptions: {
			scss: {
				additionalData: `
          @import "@/assets/scss/variables";
          @import "@/assets/scss/fonts";
          @import "@/assets/scss/helpers/mixins";
          @import "@/assets/scss/helpers/placeholders";
          @import "@/assets/scss/global";
				`,
			},
		},
	},
	build: {
		manifest: "manifest.json",
		chunkSizeWarningLimit: 1600,
	},
	server: {
		host: "0.0.0.0",
		port: 5173,
		cors: true,
		hmr: {
			host: "127.0.0.1",
			port: 5173,
		},
	},
});
