<template>
    <div class="phone-field">
        <input
            type="tel"
            :value="modelValue"
            :placeholder="placeholder ?? 'Телефон'"
            :class="[inputClass, { 'is-invalid': touched && !isValid }]"
            @focus="onFocus"
            @blur="onBlur"
            @input="onInput"
            @keydown="onKeydown"
        />
        <span v-if="touched && !isValid" class="phone-field__error">
            Введите номер полностью: +7XXXXXXXXXX
        </span>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, nextTick } from "vue";

const props = defineProps<{
    modelValue: string;
    placeholder?: string;
    inputClass?: string;
}>();

const emit = defineEmits<{ "update:modelValue": [value: string] }>();

const PREFIX = "+7";
const touched = ref(false);

// Valid = +7 + exactly 10 digits
const isValid = computed(() => /^\+7\d{10}$/.test(props.modelValue));

const onFocus = () => {
    if (!props.modelValue) emit("update:modelValue", PREFIX);
};

const onBlur = () => {
    touched.value = true;
    if (props.modelValue === PREFIX) emit("update:modelValue", "");
};

const onInput = (e: Event) => {
    const input = e.target as HTMLInputElement;
    let digits = input.value.replace(/\D/g, "");

    if (!digits) { emit("update:modelValue", PREFIX); return; }

    if (digits[0] === "7" || digits[0] === "8") digits = digits.slice(1);
    digits = digits.slice(0, 10);

    const formatted = PREFIX + digits;
    emit("update:modelValue", formatted);

    nextTick(() => {
        input.setSelectionRange(formatted.length, formatted.length);
    });
};

const onKeydown = (e: KeyboardEvent) => {
    const { selectionStart, selectionEnd } = e.target as HTMLInputElement;

    if (
        (e.key === "Backspace" || e.key === "Delete") &&
        selectionStart !== null &&
        selectionStart <= PREFIX.length &&
        (selectionEnd === selectionStart || (selectionEnd !== null && selectionEnd <= PREFIX.length))
    ) {
        e.preventDefault();
    }
};

// Expose validity so parent forms can check before submit
defineExpose({ isValid, touched });
</script>

<style lang="scss" scoped>
.phone-field {
    flex: 1;
    min-width: 160px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.phone-field__error {
    font-size: 12px;
    color: #f87171;
}

.is-invalid {
    border-color: #f87171 !important;
}
</style>
