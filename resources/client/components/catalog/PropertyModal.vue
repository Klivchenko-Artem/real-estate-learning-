<template>
	<Teleport to="body">
		<Transition name="modal">
			<div v-if="property" class="modal-overlay" @click.self="$emit('close')">
				<div class="modal">
					<button class="modal__close" @click="$emit('close')">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M18 6 6 18M6 6l12 12"/>
						</svg>
					</button>

					<div class="modal__gallery">
						<img v-if="property.image" :src="`/storage/${property.image}`" :alt="property.name" />
						<div v-else class="modal__gallery-placeholder">VOID</div>
					</div>

					<div class="modal__content">
						<div class="modal__meta">
							<span class="tag">{{ property.category?.name }}</span>
							<span class="modal__price">{{ formatPrice(property.price) }}</span>
						</div>

						<h2 class="modal__title">{{ property.name }}</h2>

						<div class="modal__specs">
							<div v-if="property.area" class="modal__spec">
								<span class="modal__spec-label">Площадь</span>
								<span class="modal__spec-value">{{ property.area }} м²</span>
							</div>
							<div v-if="property.rooms" class="modal__spec">
								<span class="modal__spec-label">Комнат</span>
								<span class="modal__spec-value">{{ property.rooms }}</span>
							</div>
							<div v-if="property.floor" class="modal__spec">
								<span class="modal__spec-label">Этаж</span>
								<span class="modal__spec-value">{{ property.floor }}/{{ property.floors_total }}</span>
							</div>
							<div v-if="property.address" class="modal__spec modal__spec--full">
								<span class="modal__spec-label">Адрес</span>
								<span class="modal__spec-value">{{ property.address }}</span>
							</div>
						</div>

						<p v-if="property.description" class="modal__description">
							{{ property.description }}
						</p>

						<form class="modal__form" @submit.prevent="submit">
							<h4 class="modal__form-title">Оставить заявку</h4>
							<div class="modal__form-row">
								<input
									v-model="form.name"
									type="text"
									placeholder="Ваше имя"
									class="modal__input"
									required
								/>
								<input
									v-model="form.phone"
									type="tel"
									placeholder="Телефон"
									class="modal__input"
									required
								/>
							</div>
							<button type="submit" class="btn btn--primary" :disabled="submitting" style="width:100%;justify-content:center">
								{{ submitting ? 'Отправляю...' : 'Отправить заявку' }}
							</button>
							<p v-if="success" class="modal__success">✓ Заявка принята! Мы свяжемся с вами.</p>
						</form>
					</div>
				</div>
			</div>
		</Transition>
	</Teleport>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps<{ property: any }>();
const emit = defineEmits(["close"]);

const form = ref({ name: "", phone: "" });
const submitting = ref(false);
const success = ref(false);

// Close on Escape
const onKey = (e: KeyboardEvent) => { if (e.key === "Escape") emit("close"); };
watch(() => props.property, (val) => {
	if (val) {
		document.addEventListener("keydown", onKey);
		document.body.style.overflow = "hidden";
		success.value = false;
	} else {
		document.removeEventListener("keydown", onKey);
		document.body.style.overflow = "";
	}
});

const submit = () => {
	submitting.value = true;
	router.post("/feedback", form.value, {
		preserveScroll: true,
		onSuccess: () => { success.value = true; form.value = { name: "", phone: "" }; },
		onFinish: () => { submitting.value = false; },
	});
};

const formatPrice = (price: number) => {
	if (price >= 1_000_000) return (price / 1_000_000).toFixed(1).replace(".0", "") + " млн ₽";
	return price.toLocaleString("ru") + " ₽";
};
</script>

<style lang="scss" scoped>
.modal-overlay {
	position: fixed;
	inset: 0;
	background: rgba(0, 0, 0, 0.75);
	backdrop-filter: blur(6px);
	z-index: 1000;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 24px;
}

.modal {
	background: $color-bg-2;
	border: 1px solid $color-border;
	border-radius: $radius-lg;
	width: 100%;
	max-width: 860px;
	max-height: 90vh;
	overflow-y: auto;
	display: grid;
	grid-template-columns: 1fr 1fr;
	position: relative;

	&__close {
		position: absolute;
		top: 16px;
		right: 16px;
		z-index: 10;
		width: 36px;
		height: 36px;
		display: flex;
		align-items: center;
		justify-content: center;
		background: rgba($color-bg, 0.7);
		border: 1px solid $color-border;
		border-radius: 50%;
		cursor: pointer;
		color: $color-text;
		transition: all $transition;
		backdrop-filter: blur(8px);

		&:hover {
			background: $color-bg-3;
			color: $color-white;
		}
	}

	&__gallery {
		height: 100%;
		min-height: 400px;

		img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			border-radius: $radius-lg 0 0 $radius-lg;
		}
	}

	&__gallery-placeholder {
		width: 100%;
		height: 100%;
		min-height: 400px;
		background: $color-surface;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 32px;
		font-weight: 800;
		color: $color-border;
		letter-spacing: 0.1em;
		border-radius: $radius-lg 0 0 $radius-lg;
	}

	&__content {
		padding: 32px;
		display: flex;
		flex-direction: column;
		gap: 20px;
	}

	&__meta {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	&__price {
		font-size: 18px;
		font-weight: 700;
		color: $color-accent;
	}

	&__title {
		font-size: 22px;
		font-weight: 700;
		color: $color-white;
		line-height: 1.3;
	}

	&__specs {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 12px;
		background: $color-bg-3;
		padding: 16px;
		border-radius: $radius-sm;
	}

	&__spec {
		display: flex;
		flex-direction: column;
		gap: 2px;

		&--full {
			grid-column: 1 / -1;
		}
	}

	&__spec-label {
		font-size: 11px;
		color: $color-text-muted;
		text-transform: uppercase;
		letter-spacing: 0.07em;
	}

	&__spec-value {
		font-size: 14px;
		font-weight: 500;
		color: $color-text;
	}

	&__description {
		font-size: 14px;
		color: $color-text-muted;
		line-height: 1.7;
	}

	&__form {
		display: flex;
		flex-direction: column;
		gap: 12px;
		border-top: 1px solid $color-border;
		padding-top: 20px;
	}

	&__form-title {
		font-size: 15px;
		font-weight: 600;
		color: $color-white;
	}

	&__form-row {
		display: flex;
		gap: 10px;
	}

	&__input {
		flex: 1;
		padding: 10px 14px;
		background: $color-bg-3;
		border: 1px solid $color-border;
		border-radius: $radius-sm;
		color: $color-text;
		font-size: 14px;
		outline: none;
		font-family: $font-main;
		transition: border-color $transition;
		min-width: 0;

		&::placeholder { color: $color-text-muted; }
		&:focus { border-color: $color-accent; }
	}

	&__success {
		font-size: 13px;
		color: #4ade80;
	}
}

// Transition
.modal-enter-active, .modal-leave-active {
	transition: opacity 0.25s ease;

	.modal {
		transition: transform 0.25s ease, opacity 0.25s ease;
	}
}

.modal-enter-from, .modal-leave-to {
	opacity: 0;

	.modal {
		transform: scale(0.95) translateY(16px);
		opacity: 0;
	}
}
</style>
