<template>
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
</template>

<script setup lang="ts">
defineProps<{ categories: any[] }>();

const categoryIcon = (slug: string): string => {
    const icons: Record<string, string> = {
        apartments: "🏢",
        lofts: "🏭",
        penthouses: "🌃",
        studios: "🏠",
    };
    return icons[slug] ?? "🏗";
};
</script>

<style lang="scss" scoped>
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

    &__icon { font-size: 24px; flex-shrink: 0; }

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
</style>
