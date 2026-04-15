import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import path from "node:path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default defineConfig({
	plugins: [
		vue(),
		laravel({
			input: ["resources/client/app.ts"],
			refresh: true,
		}),
	],
	resolve: {
		alias: {
			"@": path.join(__dirname, "/resources/client"),
			"~": path.join(__dirname, "/node_modules"),
		},
	},
	css: {
		preprocessorOptions: {
			scss: {
				additionalData: `@import "@/assets/scss/variables";`,
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
		hmr: { host: "127.0.0.1", port: 5173 },
	},
});
