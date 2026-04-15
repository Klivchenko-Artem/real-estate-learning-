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
                <CatalogFilters
                    :categories="categories"
                    :filters="filters"
                    @apply="applyFilters"
                    @reset="resetFilters"
                />

                <div class="catalog-results">
                    <p class="catalog-results__count">{{ properties.total }} объектов</p>

                    <div v-if="properties.data.length" class="catalog-grid">
                        <PropertyCard
                            v-for="prop in properties.data"
                            :key="prop.id"
                            :property="prop"
                            :show-btn="true"
                            @click="selectedProperty = prop"
                        />
                    </div>

                    <div v-else class="catalog-empty">
                        <div class="catalog-empty__icon">🔍</div>
                        <h3>Ничего не найдено</h3>
                        <p>Попробуйте изменить фильтры</p>
                        <button @click="resetFilters" class="btn btn--outline" style="margin-top:16px">
                            Сбросить фильтры
                        </button>
                    </div>

                    <CatalogPagination
                        :current-page="properties.current_page"
                        :last-page="properties.last_page"
                        @change="goToPage"
                    />
                </div>
            </div>
        </div>

        <PropertyModal :property="selectedProperty" @close="selectedProperty = null" />
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import CatalogFilters from "@/components/catalog/CatalogFilters.vue";
import CatalogPagination from "@/components/catalog/CatalogPagination.vue";
import PropertyCard from "@/components/shared/PropertyCard.vue";
import PropertyModal from "@/components/catalog/PropertyModal.vue";

const props = defineProps<{
    properties: any;
    categories: any[];
    filters: Record<string, any>;
    priceRange: { min: number; max: number };
}>();

const selectedProperty = ref<any>(null);

const applyFilters = (local: Record<string, any>) => {
    const query: Record<string, any> = {};
    const keys = ["category", "rooms", "price_min", "price_max", "area_min", "area_max"];
    keys.forEach(k => { if (local[k]) query[k] = local[k]; });
    if (local.page > 1) query.page = local.page;
    router.get("/catalog", query, { preserveScroll: true });
};

const resetFilters = () => router.get("/catalog");

const goToPage = (page: number) => {
    applyFilters({ ...props.filters, page });
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

.catalog-results {
    flex: 1;
    min-width: 0;
}

.catalog-results__count {
    font-size: 14px;
    color: $color-text-muted;
    margin-bottom: 24px;
}

.catalog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.catalog-empty {
    text-align: center;
    padding: 80px 40px;
    color: $color-text-muted;

    &__icon { font-size: 48px; margin-bottom: 16px; }
    h3 { font-size: 20px; color: $color-text; margin-bottom: 8px; }
    p { font-size: 15px; }
}
</style>
