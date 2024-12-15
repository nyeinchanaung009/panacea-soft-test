<script setup>
import { onMounted, ref } from 'vue';
import Eye from '@/Components/icons/Eye.vue';
import EyeSlash from '@/Components/icons/EyeSlash.vue';

defineProps({
    modelValue: String,
    placeholder_name : String,
    inputType : String
});

defineEmits(['update:modelValue']);

const input = ref(null);
const showPassword = ref(false);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative border-none px-0 bg-white dark:bg-primary_bg">
        <input
            ref="input"
            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded shadow-sm placeholder:text-gray-400/80"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder_name"
            :type="inputType == 'password' && !showPassword ? 'password' : 'text'"
            required
        >
        <span @click="showPassword = !showPassword" v-show="inputType == 'password'" class="absolute text-lg cursor-pointer p-2 borde right-2 top-[3.5px] hover:opacity-80 text-gray-600">
            <component :is="showPassword ? Eye : EyeSlash" />
        </span>
    </div>
</template>
