<template>
    <input
        type="tel"
        :value="modelValue"
        :placeholder="placeholder ?? 'Телефон'"
        :class="inputClass"
        @focus="onFocus"
        @blur="onBlur"
        @input="onInput"
        @keydown="onKeydown"
    />
</template>

<script setup lang="ts">
import { nextTick } from "vue";

const props = defineProps<{
    modelValue: string;
    placeholder?: string;
    inputClass?: string;
}>();

const emit = defineEmits<{ "update:modelValue": [value: string] }>();

const PREFIX = "+7";

const onFocus = () => {
    if (!props.modelValue) emit("update:modelValue", PREFIX);
};

const onBlur = () => {
    if (props.modelValue === PREFIX) emit("update:modelValue", "");
};

const onInput = (e: Event) => {
    const input = e.target as HTMLInputElement;
    let digits = input.value.replace(/\D/g, "");

    if (!digits) { emit("update:modelValue", PREFIX); return; }

    // Normalize leading 7 or 8 → strip, keep rest
    if (digits[0] === "7" || digits[0] === "8") digits = digits.slice(1);

    // Max 10 digits after country code
    digits = digits.slice(0, 10);

    const formatted = PREFIX + digits;
    emit("update:modelValue", formatted);

    nextTick(() => {
        input.setSelectionRange(formatted.length, formatted.length);
    });
};

const onKeydown = (e: KeyboardEvent) => {
    const input = e.target as HTMLInputElement;
    const { selectionStart, selectionEnd } = input;

    // Block deletion of +7 prefix
    if (
        (e.key === "Backspace" || e.key === "Delete") &&
        selectionStart !== null &&
        selectionStart <= PREFIX.length &&
        (selectionEnd === selectionStart || (selectionEnd !== null && selectionEnd <= PREFIX.length))
    ) {
        e.preventDefault();
    }
};
</script>
