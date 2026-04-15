<template>
	<div class="void-app">
		<AppHeader />
		<main>
			<slot />
		</main>
		<AppFooter />
	</div>
</template>

<script setup lang="ts">
import AppHeader from "@/components/AppHeader.vue";
import AppFooter from "@/components/AppFooter.vue";
</script>

<style lang="scss">
@import "@/assets/scss/main";
</style>
