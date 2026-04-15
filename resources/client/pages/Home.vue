<template>
    <div class="home">
        <HeroSection :hero="hero" :stats="stats" />

        <CategoriesSection :categories="categories" />

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
                    <PropertyCard
                        v-for="prop in featured"
                        :key="prop.id"
                        :property="prop"
                        @click="selectedProperty = prop"
                    />
                </div>
            </div>
        </section>

        <CtaForm />

        <PropertyModal :property="selectedProperty" @close="selectedProperty = null" />
    </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import HeroSection from "@/components/home/HeroSection.vue";
import CategoriesSection from "@/components/home/CategoriesSection.vue";
import CtaForm from "@/components/home/CtaForm.vue";
import PropertyCard from "@/components/shared/PropertyCard.vue";
import PropertyModal from "@/components/catalog/PropertyModal.vue";

defineProps<{
    featured: any[];
    categories: any[];
    stats: { properties: number; categories: number; experience: number; clients: number };
    hero: { title: string; subtitle: string };
}>();

const selectedProperty = ref<any>(null);
</script>

<style lang="scss" scoped>
.featured__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 24px;
}
</style>
