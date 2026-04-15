<template>
	<div class="catalog-page">
		<div class="catalog-hero">
			<div class="container">
				<span class="badge">Каталог</span>
				<h1 class="catalog-hero__title">Все объекты</h1>
				<p class="catalog-hero__sub">{{ properties.total }} объектов в базе</p>
			</div>
		</div>

		<div class="container">
			<div class="catalog-layout">
				<!-- Filters sidebar -->
				<aside class="filters">
					<div class="filters__header">
						<h3 class="filters__title">Фильтры</h3>
						<button v-if="hasFilters" @click="resetFilters" class="filters__reset">
							Сбросить
						</button>
					</div>

					<!-- Category -->
					<div class="filter-group">
						<label class="filter-group__label">Тип жилья</label>
						<div class="filter-options">
							<button
								class="filter-option"
								:class="{ active: !localFilters.category }"
								@click="setFilter('category', null)"
							>Все</button>
							<button
								v-for="cat in categories"
								:key="cat.id"
								class="filter-option"
								:class="{ active: localFilters.category == cat.id }"
								@click="setFilter('category', cat.id)"
							>{{ cat.name }}</button>
						</div>
					</div>

					<!-- Rooms -->
					<div class="filter-group">
						<label class="filter-group__label">Комнат</label>
						<div class="filter-options">
							<button
								v-for="r in [null, 1, 2, 3, 4]"
								:key="String(r)"
								class="filter-option"
								:class="{ active: localFilters.rooms == r }"
								@click="setFilter('rooms', r)"
							>{{ r ?? 'Любое' }}</button>
						</div>
					</div>

					<!-- Price -->
					<div class="filter-group">
						<label class="filter-group__label">Цена, ₽</label>
						<div class="filter-range">
							<input
								v-model="localFilters.price_min"
								type="number"
								placeholder="от"
								class="filter-input"
								@change="applyFilters"
							/>
							<span class="filter-range__sep">—</span>
							<input
								v-model="localFilters.price_max"
								type="number"
								placeholder="до"
								class="filter-input"
								@change="applyFilters"
							/>
						</div>
					</div>

					<!-- Area -->
					<div class="filter-group">
						<label class="filter-group__label">Площадь, м²</label>
						<div class="filter-range">
							<input
								v-model="localFilters.area_min"
								type="number"
								placeholder="от"
								class="filter-input"
								@change="applyFilters"
							/>
							<span class="filter-range__sep">—</span>
							<input
								v-model="localFilters.area_max"
								type="number"
								placeholder="до"
								class="filter-input"
								@change="applyFilters"
							/>
						</div>
					</div>

					<button @click="applyFilters" class="btn btn--primary" style="width:100%;justify-content:center">
						Применить
					</button>
				</aside>

				<!-- Results -->
				<div class="catalog-results">
					<div class="catalog-results__header">
						<span class="catalog-results__count">
							{{ properties.total }} объектов
						</span>
					</div>

					<div v-if="properties.data.length" class="catalog-grid">
						<div
							v-for="prop in properties.data"
							:key="prop.id"
							class="prop-card"
							@click="selectedProperty = prop"
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
								<div class="prop-card__details">
									<span v-if="prop.rooms">{{ prop.rooms }} комн.</span>
									<span v-if="prop.floor">{{ prop.floor }}/{{ prop.floors_total }} эт.</span>
									<span v-if="prop.address">{{ prop.address }}</span>
								</div>
								<button class="prop-card__btn">
									Подробнее
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M5 12h14M12 5l7 7-7 7"/>
									</svg>
								</button>
							</div>
						</div>
					</div>

					<div v-else class="catalog-empty">
						<div class="catalog-empty__icon">🔍</div>
						<h3>Ничего не найдено</h3>
						<p>Попробуйте изменить фильтры</p>
						<button @click="resetFilters" class="btn btn--outline" style="margin-top:16px">
							Сбросить фильтры
						</button>
					</div>

					<!-- Pagination -->
					<div v-if="properties.last_page > 1" class="pagination">
						<button
							v-for="page in properties.last_page"
							:key="page"
							class="pagination__btn"
							:class="{ active: page === properties.current_page }"
							@click="goToPage(page)"
						>{{ page }}</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<PropertyModal :property="selectedProperty" @close="selectedProperty = null" />
	</div>
</template>

<script setup lang="ts">
import { ref, computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import PropertyModal from "@/components/catalog/PropertyModal.vue";

const props = defineProps<{
	properties: any;
	categories: any[];
	filters: Record<string, any>;
	priceRange: { min: number; max: number };
}>();

const selectedProperty = ref<any>(null);

const localFilters = reactive({
	category: props.filters.category ?? null,
	rooms: props.filters.rooms ?? null,
	price_min: props.filters.price_min ?? "",
	price_max: props.filters.price_max ?? "",
	area_min: props.filters.area_min ?? "",
	area_max: props.filters.area_max ?? "",
	page: props.filters.page ?? 1,
});

const hasFilters = computed(() =>
	localFilters.category || localFilters.rooms || localFilters.price_min ||
	localFilters.price_max || localFilters.area_min || localFilters.area_max
);

const setFilter = (key: string, value: any) => {
	(localFilters as any)[key] = value;
	localFilters.page = 1;
	applyFilters();
};

const applyFilters = () => {
	const query: Record<string, any> = {};
	if (localFilters.category) query.category = localFilters.category;
	if (localFilters.rooms) query.rooms = localFilters.rooms;
	if (localFilters.price_min) query.price_min = localFilters.price_min;
	if (localFilters.price_max) query.price_max = localFilters.price_max;
	if (localFilters.area_min) query.area_min = localFilters.area_min;
	if (localFilters.area_max) query.area_max = localFilters.area_max;
	if (localFilters.page > 1) query.page = localFilters.page;
	router.get("/catalog", query, { preserveScroll: true });
};

const resetFilters = () => {
	Object.assign(localFilters, { category: null, rooms: null, price_min: "", price_max: "", area_min: "", area_max: "", page: 1 });
	router.get("/catalog");
};

const goToPage = (page: number) => {
	localFilters.page = page;
	applyFilters();
};

const formatPrice = (price: number) => {
	if (price >= 1_000_000) return (price / 1_000_000).toFixed(1).replace(".0", "") + " млн ₽";
	return price.toLocaleString("ru") + " ₽";
};
</script>

<style lang="scss" scoped>
.catalog-page {
	padding-top: 80px;
	min-height: 100vh;
}

.catalog-hero {
	padding: 60px 0 40px;
	border-bottom: 1px solid $color-border;
	margin-bottom: 48px;

	.badge { margin-bottom: 16px; }

	&__title {
		font-size: clamp(32px, 4vw, 52px);
		font-weight: 800;
		color: $color-white;
		letter-spacing: -0.03em;
		margin: 12px 0 8px;
	}

	&__sub {
		font-size: 16px;
		color: $color-text-muted;
	}
}

.catalog-layout {
	display: flex;
	gap: 48px;
	padding-bottom: 80px;
}

// Filters
.filters {
	width: 260px;
	flex-shrink: 0;

	&__header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 28px;
	}

	&__title {
		font-size: 16px;
		font-weight: 600;
		color: $color-white;
	}

	&__reset {
		font-size: 13px;
		color: $color-accent;
		background: none;
		border: none;
		cursor: pointer;
		transition: opacity $transition;
		font-family: $font-main;
		&:hover { opacity: 0.7; }
	}
}

.filter-group {
	margin-bottom: 28px;

	&__label {
		display: block;
		font-size: 13px;
		font-weight: 500;
		color: $color-text-muted;
		text-transform: uppercase;
		letter-spacing: 0.07em;
		margin-bottom: 12px;
	}
}

.filter-options {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
}

.filter-option {
	padding: 6px 14px;
	border-radius: $radius-sm;
	border: 1px solid $color-border;
	background: transparent;
	color: $color-text-muted;
	font-size: 13px;
	font-weight: 500;
	cursor: pointer;
	transition: all $transition;
	font-family: $font-main;

	&:hover { border-color: $color-accent; color: $color-accent; }

	&.active {
		background: $color-accent;
		border-color: $color-accent;
		color: $color-white;
	}
}

.filter-range {
	display: flex;
	align-items: center;
	gap: 8px;

	&__sep {
		color: $color-text-muted;
		flex-shrink: 0;
	}
}

.filter-input {
	flex: 1;
	padding: 8px 12px;
	background: $color-bg-3;
	border: 1px solid $color-border;
	border-radius: $radius-sm;
	color: $color-text;
	font-size: 14px;
	outline: none;
	font-family: $font-main;
	min-width: 0;
	transition: border-color $transition;

	&::placeholder { color: $color-text-muted; }
	&:focus { border-color: $color-accent; }

	/* Hide arrows */
	&::-webkit-outer-spin-button,
	&::-webkit-inner-spin-button { -webkit-appearance: none; }
}

// Results
.catalog-results {
	flex: 1;
	min-width: 0;
}

.catalog-results__header {
	margin-bottom: 24px;
}

.catalog-results__count {
	font-size: 14px;
	color: $color-text-muted;
}

.catalog-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
	gap: 24px;
	margin-bottom: 40px;
}

// Card (same as Home but scoped)
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
		height: 200px;
		overflow: hidden;

		img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			transition: transform 0.4s ease;
		}

		&:hover img { transform: scale(1.05); }
	}

	&__image-placeholder {
		width: 100%;
		height: 100%;
		background: $color-surface;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 20px;
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
		padding: 18px;
	}

	&__meta {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-bottom: 10px;
	}

	&__area {
		font-size: 13px;
		color: $color-text-muted;
	}

	&__title {
		font-size: 17px;
		font-weight: 600;
		color: $color-white;
		margin-bottom: 8px;
		line-height: 1.3;
	}

	&__desc {
		font-size: 13px;
		color: $color-text-muted;
		line-height: 1.5;
		margin-bottom: 12px;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	&__details {
		display: flex;
		gap: 10px;
		flex-wrap: wrap;
		margin-bottom: 14px;

		span {
			font-size: 12px;
			color: $color-text-muted;
			&::before { content: "· "; color: $color-border; }
			&:first-child::before { display: none; }
		}
	}

	&__btn {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 13px;
		font-weight: 500;
		color: $color-accent;
		background: none;
		border: none;
		cursor: pointer;
		padding: 0;
		font-family: $font-main;
		transition: gap $transition;

		&:hover { gap: 10px; }
	}
}

// Empty state
.catalog-empty {
	text-align: center;
	padding: 80px 40px;
	color: $color-text-muted;

	&__icon { font-size: 48px; margin-bottom: 16px; }
	h3 { font-size: 20px; color: $color-text; margin-bottom: 8px; }
	p { font-size: 15px; }
}

// Pagination
.pagination {
	display: flex;
	gap: 8px;
	flex-wrap: wrap;

	&__btn {
		width: 38px;
		height: 38px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: $radius-sm;
		border: 1px solid $color-border;
		background: transparent;
		color: $color-text-muted;
		font-size: 14px;
		cursor: pointer;
		font-family: $font-main;
		transition: all $transition;

		&:hover { border-color: $color-accent; color: $color-accent; }
		&.active { background: $color-accent; border-color: $color-accent; color: $color-white; }
	}
}
</style>
