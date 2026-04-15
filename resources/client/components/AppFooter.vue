<template>
	<footer class="footer">
		<div class="container">
			<div class="footer__inner">
				<div class="footer__brand">
					<span class="footer__logo">VOID</span>
					<p class="footer__desc">Премиальная недвижимость.<br>Найдите своё пространство.</p>
				</div>
				<nav class="footer__nav">
					<a href="/">Главная</a>
					<a href="/catalog">Каталог</a>
				</nav>
			</div>
			<div class="footer__bottom">
				<span>© {{ year }} VOID. Все права защищены.</span>
			</div>
		</div>
	</footer>
</template>

<script setup lang="ts">
const year = new Date().getFullYear();
</script>

<style lang="scss" scoped>
.footer {
	border-top: 1px solid $color-border;
	padding: 60px 0 32px;
	background: $color-bg-2;

	&__inner {
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		gap: 40px;
		margin-bottom: 48px;
	}

	&__logo {
		font-size: 20px;
		font-weight: 800;
		letter-spacing: 0.15em;
		color: $color-white;
		display: block;
		margin-bottom: 12px;
	}

	&__desc {
		font-size: 14px;
		color: $color-text-muted;
		line-height: 1.6;
	}

	&__nav {
		display: flex;
		flex-direction: column;
		gap: 12px;

		a {
			font-size: 14px;
			color: $color-text-muted;
			transition: color $transition;
			&:hover { color: $color-text; }
		}
	}

	&__bottom {
		border-top: 1px solid $color-border;
		padding-top: 24px;
		font-size: 13px;
		color: $color-text-muted;
	}
}
</style>
