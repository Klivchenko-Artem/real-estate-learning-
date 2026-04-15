<template>
    <div v-if="lastPage > 1" class="pagination">
        <button
            v-for="page in lastPage"
            :key="page"
            class="pagination__btn"
            :class="{ active: page === currentPage }"
            @click="$emit('change', page)"
        >{{ page }}</button>
    </div>
</template>

<script setup lang="ts">
defineProps<{ currentPage: number; lastPage: number }>();
defineEmits<{ change: [page: number] }>();
</script>

<style lang="scss" scoped>
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
