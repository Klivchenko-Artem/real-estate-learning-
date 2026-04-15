<template>
    <div class="prop-card" @click="$emit('click', property)">
        <div class="prop-card__image">
            <img v-if="property.image" :src="`/storage/${property.image}`" :alt="property.name" />
            <div v-else class="prop-card__image-placeholder"><span>VOID</span></div>
            <span class="prop-card__price">{{ formatPrice(property.price) }}</span>
        </div>
        <div class="prop-card__body">
            <div class="prop-card__meta">
                <span class="tag">{{ property.category?.name }}</span>
                <span class="prop-card__area">{{ property.area }} м²</span>
            </div>
            <h3 class="prop-card__title">{{ property.name }}</h3>
            <p class="prop-card__desc">{{ property.short_description }}</p>
            <div class="prop-card__details" v-if="property.rooms || property.floor || property.address">
                <span v-if="property.rooms">{{ property.rooms }} комн.</span>
                <span v-if="property.floor">{{ property.floor }}/{{ property.floors_total }} эт.</span>
                <span v-if="property.address">{{ property.address }}</span>
            </div>
            <button v-if="showBtn" class="prop-card__btn">
                Подробнее
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useFormatPrice } from "@/composables/useFormatPrice";

defineProps<{
    property: any;
    showBtn?: boolean;
}>();

defineEmits<{ click: [property: any] }>();

const { formatPrice } = useFormatPrice();
</script>

<style lang="scss" scoped>
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
        height: 210px;
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
        font-size: 22px;
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

    &__body { padding: 18px; }

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
</style>
