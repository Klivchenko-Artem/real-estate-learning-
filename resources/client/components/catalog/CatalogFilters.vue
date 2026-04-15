<template>
    <aside class="filters">
        <div class="filters__header">
            <h3 class="filters__title">Фильтры</h3>
            <button v-if="hasFilters" @click="$emit('reset')" class="filters__reset">Сбросить</button>
        </div>

        <div class="filter-group">
            <label class="filter-group__label">Тип жилья</label>
            <div class="filter-options">
                <button class="filter-option" :class="{ active: !local.category }" @click="set('category', null)">Все</button>
                <button
                    v-for="cat in categories"
                    :key="cat.id"
                    class="filter-option"
                    :class="{ active: local.category == cat.id }"
                    @click="set('category', cat.id)"
                >{{ cat.name }}</button>
            </div>
        </div>

        <div class="filter-group">
            <label class="filter-group__label">Комнат</label>
            <div class="filter-options">
                <button
                    v-for="r in [null, 1, 2, 3, 4]"
                    :key="String(r)"
                    class="filter-option"
                    :class="{ active: local.rooms == r }"
                    @click="set('rooms', r)"
                >{{ r ?? 'Любое' }}</button>
            </div>
        </div>

        <div class="filter-group">
            <label class="filter-group__label">Цена, ₽</label>
            <div class="filter-range">
                <input v-model="local.price_min" type="number" placeholder="от" class="filter-input" @change="$emit('apply', local)" />
                <span class="filter-range__sep">—</span>
                <input v-model="local.price_max" type="number" placeholder="до" class="filter-input" @change="$emit('apply', local)" />
            </div>
        </div>

        <div class="filter-group">
            <label class="filter-group__label">Площадь, м²</label>
            <div class="filter-range">
                <input v-model="local.area_min" type="number" placeholder="от" class="filter-input" @change="$emit('apply', local)" />
                <span class="filter-range__sep">—</span>
                <input v-model="local.area_max" type="number" placeholder="до" class="filter-input" @change="$emit('apply', local)" />
            </div>
        </div>

        <button @click="$emit('apply', local)" class="btn btn--primary" style="width:100%;justify-content:center">
            Применить
        </button>
    </aside>
</template>

<script setup lang="ts">
import { reactive, computed } from "vue";

const props = defineProps<{
    categories: any[];
    filters: Record<string, any>;
}>();

const emit = defineEmits<{
    apply: [filters: Record<string, any>];
    reset: [];
}>();

const local = reactive({
    category: props.filters.category ?? null,
    rooms:     props.filters.rooms ?? null,
    price_min: props.filters.price_min ?? "",
    price_max: props.filters.price_max ?? "",
    area_min:  props.filters.area_min ?? "",
    area_max:  props.filters.area_max ?? "",
    page: 1,
});

const hasFilters = computed(() =>
    local.category || local.rooms || local.price_min || local.price_max || local.area_min || local.area_max
);

const set = (key: string, value: any) => {
    (local as any)[key] = value;
    local.page = 1;
    emit("apply", local);
};
</script>

<style lang="scss" scoped>
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
    &.active { background: $color-accent; border-color: $color-accent; color: $color-white; }
}

.filter-range {
    display: flex;
    align-items: center;
    gap: 8px;

    &__sep { color: $color-text-muted; flex-shrink: 0; }
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
    &::-webkit-outer-spin-button,
    &::-webkit-inner-spin-button { -webkit-appearance: none; }
}
</style>
