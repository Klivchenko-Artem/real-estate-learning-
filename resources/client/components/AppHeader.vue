<template>
	<header class="header" :class="{ 'header--scrolled': scrolled }">
		<div class="container">
			<div class="header__inner">
				<a href="/" class="header__logo">VOID</a>
				<nav class="header__nav">
					<a href="/" class="header__link" :class="{ active: isHome }">Главная</a>
					<a href="/catalog" class="header__link" :class="{ active: isCatalog }">Каталог</a>
				</nav>
				<a href="/catalog" class="btn btn--primary header__cta">
					Смотреть объекты
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M5 12h14M12 5l7 7-7 7"/>
					</svg>
				</a>
			</div>
		</div>
	</header>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const scrolled = ref(false);
const page = usePage();

const isHome = computed(() => page.url === "/");
const isCatalog = computed(() => page.url.startsWith("/catalog"));

const onScroll = () => { scrolled.value = window.scrollY > 40; };
onMounted(() => window.addEventListener("scroll", onScroll));
onUnmounted(() => window.removeEventListener("scroll", onScroll));
</script>

<style lang="scss" scoped>
.header {
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	z-index: 100;
	padding: 20px 0;
	transition: all 0.3s ease;

	&--scrolled {
		background: rgba($color-bg, 0.92);
		backdrop-filter: blur(12px);
		padding: 12px 0;
		border-bottom: 1px solid $color-border;
	}

	&__inner {
		display: flex;
		align-items: center;
		gap: 40px;
	}

	&__logo {
		font-size: 22px;
		font-weight: 800;
		letter-spacing: 0.15em;
		color: $color-white;
		flex-shrink: 0;
	}

	&__nav {
		display: flex;
		gap: 32px;
		flex: 1;
	}

	&__link {
		font-size: 14px;
		font-weight: 500;
		color: $color-text-muted;
		transition: color $transition;
		&:hover, &.active {
			color: $color-text;
		}
	}

	&__cta {
		margin-left: auto;
		flex-shrink: 0;
		font-size: 13px;
		padding: 10px 20px;
	}
}
</style>
