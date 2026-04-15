import { createApp, h, type DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import AppLayout from "@/App.vue";

createInertiaApp({
	progress: { delay: 0, color: "#6366f1" },
	resolve: (name) => {
		const pages = import.meta.glob<DefineComponent>("./pages/**/*.vue", { eager: true });
		const page = pages[`./pages/${name}.vue`];
		page.default.layout ??= AppLayout;
		return page;
	},
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.mount(el);
	},
});
