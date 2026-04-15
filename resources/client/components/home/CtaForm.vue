<template>
    <section class="section cta-section">
        <div class="container">
            <div class="cta-block">
                <div class="cta-block__content">
                    <h2 class="cta-block__title">Не нашли подходящий вариант?</h2>
                    <p class="cta-block__text">Оставьте заявку и мы подберём объект под ваши требования</p>
                </div>
                <form class="cta-form" @submit.prevent="submit">
                    <div class="cta-form__row">
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Ваше имя"
                            class="cta-form__input"
                            required
                        />
                        <PhoneInput
                            ref="phoneRef"
                            v-model="form.phone"
                            input-class="cta-form__input"
                        />
                    </div>
                    <button type="submit" class="btn btn--primary" :disabled="submitting">
                        {{ submitting ? "Отправляю..." : "Оставить заявку" }}
                    </button>
                    <p v-if="flashSuccess" class="cta-form__success">✓ Заявка принята! Мы свяжемся с вами.</p>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import PhoneInput from "@/components/shared/PhoneInput.vue";

const page = usePage();
const flashSuccess = computed(() => (page.props as any).flash?.success);

const phoneRef = ref<InstanceType<typeof PhoneInput> | null>(null);
const form = useForm({ name: "", phone: "" });

const submit = () => {
    if (phoneRef.value) phoneRef.value.touched = true;
    if (!phoneRef.value?.isValid) return;

    form.post("/feedback", {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<style lang="scss" scoped>
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

    :deep(.cta-form__input) {
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
        width: 100%;

        &::placeholder { color: $color-text-muted; }
        &:focus { border-color: $color-accent; }
    }

    &__success {
        font-size: 14px;
        color: #4ade80;
    }
}
</style>
