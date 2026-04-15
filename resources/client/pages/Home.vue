<template>
	<div class="home">
		<!-- Hero -->
		<section class="hero">
			<div class="hero__bg">
				<div class="hero__grid" />
				<div class="hero__glow" />
			</div>
			<div class="container">
				<div class="hero__content">
					<span class="badge">Премиальная недвижимость</span>
					<h1 class="hero__title" v-html="formattedTitle" />
					<p class="hero__subtitle">{{ hero.subtitle }}</p>
					<div class="hero__actions">
						<a href="/catalog" class="btn btn--primary">
							Смотреть каталог
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M5 12h14M12 5l7 7-7 7"/>
							</svg>
						</a>
						<a href="#featured" class="btn btn--outline">Избранные объекты</a>
					</div>
				</div>
			</div>
			<!-- Stats bar -->
			<div class="hero__stats">
				<div class="container">
					<div class="stats-bar">
						<div class="stats-bar__item">
							<span class="stats-bar__value">{{ stats.properties }}+</span>
							<span class="stats-bar__label">Объектов в базе</span>
						</div>
						<div class="stats-bar__divider" />
						<div class="stats-bar__item">
							<span class="stats-bar__value">{{ stats.categories }}</span>
							<span class="stats-bar__label">Категорий</span>
						</div>
						<div class="stats-bar__divider" />
						<div class="stats-bar__item">
							<span class="stats-bar__value">{{ stats.experience }}+</span>
							<span class="stats-bar__label">Лет на рынке</span>
						</div>
						<div class="stats-bar__divider" />
						<div class="stats-bar__item">
							<span class="stats-bar__value">{{ stats.clients }}+</span>
							<span class="stats-bar__label">Довольных клиентов</span>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Categories -->
		<section class="section categories">
			<div class="container">
				<div class="section-header">
					<span class="badge">Типы жилья</span>
					<h2 class="section-title">Выберите категорию</h2>
				</div>
				<div class="categories__grid">
					<a
						v-for="cat in categories"
						:key="cat.id"
						:href="`/catalog?category=${cat.id}`"
						class="category-card"
					>
						<span class="category-card__icon">{{ categoryIcon(cat.slug) }}</span>
						<span class="category-card__name">{{ cat.name }}</span>
						<svg class="category-card__arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M5 12h14M12 5l7 7-7 7"/>
						</svg>
					</a>
				</div>
			</div>
		</section>

		<!-- Featured -->
		<section id="featured" class="section featured">
			<div class="container">
				<div class="section-header">
					<span class="badge">Избранное</span>
					<h2 class="section-title">Топ объекты</h2>
					<a href="/catalog" class="btn btn--ghost">
						Весь каталог
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M5 12h14M12 5l7 7-7 7"/>
						</svg>
					</a>
				</div>
				<div class="featured__grid">
					<div
						v-for="prop in featured"
						:key="prop.id"
						class="prop-card"
						@click="openModal(prop)"
					>
						<div class="prop-card__image">
							<img v-if="prop.image" :src="`/storage/${prop.image}`" :alt="prop.name" />
							<div v-else class="prop-card__image-placeholder">
								<span>VOID</span>
							</div>
							<span class="prop-card__price">{{ formatPrice(prop.price) }}</span>
						</div>
						<div class="prop-card__body">
							<div class="prop-card__meta">
								<span class="tag">{{ prop.category?.name }}</span>
								<span class="prop-card__area">{{ prop.area }} м²</span>
							</div>
							<h3 class="prop-card__title">{{ prop.name }}</h3>
							<p class="prop-card__desc">{{ prop.short_description }}</p>
							<div class="prop-card__details" v-if="prop.rooms || prop.floor">
								<span v-if="prop.rooms">{{ prop.rooms }} комн.</span>
								<span v-if="prop.floor">{{ prop.floor }}/{{ prop.floors_total }} эт.</span>
								<span v-if="prop.address">{{ prop.address }}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- CTA Section -->
		<section class="section cta-section">
			<div class="container">
				<div class="cta-block">
					<div class="cta-block__content">
						<h2 class="cta-block__title">Не нашли подходящий вариант?</h2>
						<p class="cta-block__text">Оставьте заявку и мы подберём объект под ваши требования</p>
					</div>
					<form class="cta-form" @submit.prevent="submitForm">
						<div class="cta-form__row">
							<input
								v-model="form.name"
								type="text"
								placeholder="Ваше имя"
								class="cta-form__input"
								required
							/>
							<input
								v-model="form.phone"
								type="tel"
								placeholder="Телефон"
								class="cta-form__input"
								required
							/>
						</div>
						<button type="submit" class="btn btn--primary" :disabled="submitting">
							{{ submitting ? 'Отправляю...' : 'Оставить заявку' }}
						</button>
						<p v-if="formSuccess" class="cta-form__success">✓ Заявка принята! Мы свяжемся с вами.</p>
					</form>
				</div>
			</div>
		</section>

		<!-- Modal -->
		<PropertyModal :property="selectedProperty" @close="selectedProperty = null" />
	</div>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import PropertyModal from "@/components/catalog/PropertyModal.vue";

const props = defineProps<{
	featured: any[];
	categories: any[];
	stats: { properties: number; categories: number; experience: number; clients: number };
	hero: { title: string; subtitle: string };
}>();

const selectedProperty = ref<any>(null);
const form = ref({ name: "", phone: "" });
const submitting = ref(false);
const formSuccess = ref(false);

const formattedTitle = computed(() =>
	props.hero.title.replace(/\s+(\S+)$/, ' <span class="accent">$1</span>')
);

const openModal = (prop: any) => { selectedProperty.value = prop; };

const formatPrice = (price: number) => {
	if (price >= 1_000_000) return (price / 1_000_000).toFixed(1).replace(".0", "") + " млн ₽";
	return price.toLocaleString("ru") + " ₽";
};

const categoryIcon = (slug: string): string => {
	const icons: Record<string, string> = {
		apartments: "🏢",
		lofts: "🏭",
		penthouses: "🌃",
		studios: "🏠",
	};
	return icons[slug] ?? "🏗";
};

const submitForm = () => {
	submitting.value = true;
	router.post("/feedback", form.value, {
		preserveScroll: true,
		onSuccess: () => {
			formSuccess.value = true;
			form.value = { name: "", phone: "" };
		},
		onFinish: () => { submitting.value = false; },
	});
};
</script>

<style lang="scss" scoped>
// Hero
.hero {
	position: relative;
	min-height: 100vh;
	display: flex;
	flex-direction: column;
	justify-content: center;
	overflow: hidden;
	padding-top: 80px;

	&__bg {
		position: absolute;
		inset: 0;
		pointer-events: none;
	}

	&__grid {
		position: absolute;
		inset: 0;
		background-image:
			linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
			linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
		background-size: 60px 60px;
	}

	&__glow {
		position: absolute;
		top: -200px;
		left: 50%;
		transform: translateX(-50%);
		width: 800px;
		height: 800px;
		background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
		border-radius: 50%;
	}

	&__content {
		position: relative;
		z-index: 1;
		padding: 80px 0 160px;
		max-width: 720px;

		.badge {
			margin-bottom: 24px;
		}
	}

	&__title {
		font-size: clamp(42px, 6vw, 80px);
		font-weight: 800;
		line-height: 1.05;
		letter-spacing: -0.03em;
		color: $color-white;
		margin: 16px 0 24px;

		:deep(.accent) {
			color: $color-accent;
		}
	}

	&__subtitle {
		font-size: 18px;
		color: $color-text-muted;
		max-width: 480px;
		margin-bottom: 40px;
		line-height: 1.7;
	}

	&__actions {
		display: flex;
		gap: 16px;
		flex-wrap: wrap;
	}

	&__stats {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		background: rgba($color-bg-2, 0.8);
		backdrop-filter: blur(12px);
		border-top: 1px solid $color-border;
	}
}

.stats-bar {
	display: flex;
	align-items: center;
	padding: 24px 0;
	gap: 0;

	&__item {
		flex: 1;
		text-align: center;
		padding: 0 24px;
	}

	&__value {
		display: block;
		font-size: 28px;
		font-weight: 700;
		color: $color-white;
		line-height: 1;
		margin-bottom: 6px;
	}

	&__label {
		font-size: 13px;
		color: $color-text-muted;
	}

	&__divider {
		width: 1px;
		height: 40px;
		background: $color-border;
		flex-shrink: 0;
	}
}

// Section
.section-header {
	display: flex;
	align-items: center;
	gap: 16px;
	margin-bottom: 40px;
	flex-wrap: wrap;
}

.section-title {
	font-size: clamp(24px, 3vw, 36px);
	font-weight: 700;
	color: $color-white;
	letter-spacing: -0.02em;
	margin: 0;
	flex: 1;
}

// Categories
.categories__grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
	gap: 16px;
}

.category-card {
	display: flex;
	align-items: center;
	gap: 14px;
	padding: 20px 24px;
	background: $color-bg-2;
	border: 1px solid $color-border;
	border-radius: $radius;
	transition: all $transition;
	cursor: pointer;

	&:hover {
		border-color: $color-accent;
		background: rgba($color-accent, 0.05);
		transform: translateY(-2px);
	}

	&__icon {
		font-size: 24px;
		flex-shrink: 0;
	}

	&__name {
		font-size: 15px;
		font-weight: 500;
		color: $color-text;
		flex: 1;
	}

	&__arrow {
		color: $color-text-muted;
		flex-shrink: 0;
		transition: transform $transition;
	}

	&:hover &__arrow {
		transform: translateX(4px);
		color: $color-accent;
	}
}

// Property card
.featured__grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
	gap: 24px;
}

.prop-card {
	background: $color-bg-2;
	border: 1px solid $color-border;
	border-radius: $radius;
	overflow: hidden;
	cursor: pointer;
	transition: all $transition;

	&:hover {
		border-color: rgba($color-accent, 0.5);
		transform: translateY(-4px);
		box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
	}

	&__image {
		position: relative;
		height: 220px;
		overflow: hidden;

		img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			transition: transform 0.4s ease;
		}

		&:hover img {
			transform: scale(1.05);
		}
	}

	&__image-placeholder {
		width: 100%;
		height: 100%;
		background: $color-surface;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
		font-weight: 800;
		color: $color-border;
		letter-spacing: 0.1em;
	}

	&__price {
		position: absolute;
		bottom: 12px;
		right: 12px;
		background: rgba($color-bg, 0.85);
		backdrop-filter: blur(8px);
		color: $color-white;
		padding: 6px 14px;
		border-radius: $radius-sm;
		font-size: 14px;
		font-weight: 600;
	}

	&__body {
		padding: 20px;
	}

	&__meta {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-bottom: 12px;
	}

	&__area {
		font-size: 13px;
		color: $color-text-muted;
	}

	&__title {
		font-size: 18px;
		font-weight: 600;
		color: $color-white;
		margin-bottom: 8px;
		line-height: 1.3;
	}

	&__desc {
		font-size: 14px;
		color: $color-text-muted;
		line-height: 1.5;
		margin-bottom: 14px;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	&__details {
		display: flex;
		gap: 12px;
		flex-wrap: wrap;

		span {
			font-size: 13px;
			color: $color-text-muted;
			&::before {
				content: "·";
				margin-right: 6px;
				color: $color-border;
			}
			&:first-child::before { display: none; }
		}
	}
}

// CTA Section
.cta-section {
	background: $color-bg-2;
	border-top: 1px solid $color-border;
	border-bottom: 1px solid $color-border;
}

.cta-block {
	display: flex;
	align-items: center;
	gap: 60px;
	flex-wrap: wrap;
}

.cta-block__title {
	font-size: 28px;
	font-weight: 700;
	color: $color-white;
	margin-bottom: 10px;
}

.cta-block__text {
	font-size: 15px;
	color: $color-text-muted;
}

.cta-form {
	display: flex;
	flex-direction: column;
	gap: 12px;
	flex: 1;
	min-width: 320px;

	&__row {
		display: flex;
		gap: 12px;
		flex-wrap: wrap;
	}

	&__input {
		flex: 1;
		min-width: 160px;
		padding: 12px 16px;
		background: $color-bg-3;
		border: 1px solid $color-border;
		border-radius: $radius-sm;
		color: $color-text;
		font-size: 15px;
		outline: none;
		transition: border-color $transition;
		font-family: $font-main;

		&::placeholder { color: $color-text-muted; }

		&:focus { border-color: $color-accent; }
	}

	&__success {
		font-size: 14px;
		color: #4ade80;
	}
}
</style>
