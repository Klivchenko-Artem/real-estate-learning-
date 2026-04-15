<template>
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
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
    hero: { title: string; subtitle: string };
    stats: { properties: number; categories: number; experience: number; clients: number };
}>();

const formattedTitle = computed(() =>
    props.hero.title.replace(/\s+(\S+)$/, ' <span class="accent">$1</span>')
);
</script>

<style lang="scss" scoped>
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

        .badge { margin-bottom: 24px; }
    }

    &__title {
        font-size: clamp(42px, 6vw, 80px);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.03em;
        color: $color-white;
        margin: 16px 0 24px;

        :deep(.accent) { color: $color-accent; }
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
</style>
