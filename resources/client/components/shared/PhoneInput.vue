<template>
    <div class="phone-field">
        <input
            type="tel"
            :value="modelValue"
            :placeholder="placeholder ?? 'Телефон'"
            :class="[inputClass, { 'is-invalid': touched && !isValid }]"
            @focus="onFocus"
            @blur="onBlur"
            @keydown="onKeydown"
            @input="onInput"
            @paste="onPaste"
        />
        <span v-if="touched && !isValid" class="phone-field__error">
            Введите номер: +7 и 10 цифр
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
const MAX_DIGITS = 11; // 7 + 10

const touched = ref(false);
const isValid = computed(() => /^\+7\d{10}$/.test(props.modelValue));

// Digits currently in the value (including the 7 from +7)
const currentDigitCount = () => props.modelValue.replace(/\D/g, "").length;

const applyFormat = (raw: string): string => {
    let digits = raw.replace(/\D/g, "");
    // Normalize leading 7 or 8
    if (digits.startsWith("7") || digits.startsWith("8")) digits = digits.slice(1);
    digits = digits.slice(0, 10); // max 10 digits after country code
    return PREFIX + digits;
};

const onFocus = () => {
    if (!props.modelValue) emit("update:modelValue", PREFIX);
};

const onBlur = () => {
    touched.value = true;
    if (props.modelValue === PREFIX || !props.modelValue) {
        emit("update:modelValue", "");
    }
};

const CONTROL_KEYS = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab", "Enter", "Home", "End"];

const onKeydown = (e: KeyboardEvent) => {
    const input = e.target as HTMLInputElement;
    const { selectionStart, selectionEnd } = input;

    // Allow control combos (Ctrl+A, Ctrl+C, etc.)
    if (e.ctrlKey || e.metaKey) return;

    // Allow control keys
    if (CONTROL_KEYS.includes(e.key)) {
        // Block deletion of +7 prefix
        if ((e.key === "Backspace" || e.key === "Delete") &&
            selectionStart !== null && selectionStart <= PREFIX.length &&
            selectionStart === selectionEnd) {
            e.preventDefault();
        }
        return;
    }

    // Block non-digits
    if (!/^\d$/.test(e.key)) {
        e.preventDefault();
        return;
    }

    // Block if already at max
    if (currentDigitCount() >= MAX_DIGITS && selectionStart === selectionEnd) {
        e.preventDefault();
    }
};

const onInput = (e: Event) => {
    const input = e.target as HTMLInputElement;
    const formatted = applyFormat(input.value);
    emit("update:modelValue", formatted);

    nextTick(() => {
        const pos = Math.max(formatted.length, PREFIX.length);
        input.setSelectionRange(pos, pos);
    });
};

const onPaste = (e: ClipboardEvent) => {
    e.preventDefault();
    const text = e.clipboardData?.getData("text") ?? "";
    const formatted = applyFormat((props.modelValue ?? "") + text);
    emit("update:modelValue", formatted);
};

defineExpose({ isValid, touched });
</script>

<style lang="scss" scoped>
.phone-field {
    flex: 1;
    min-width: 160px;
    position: relative;
}

.phone-field__error {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    font-size: 11px;
    color: #f87171;
    white-space: nowrap;
    pointer-events: none;
    z-index: 10;
}

.is-invalid {
    border-color: #f87171 !important;
}
</style>
