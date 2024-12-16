<script setup>
import {Link } from '@inertiajs/vue3';
import Pen from '@/Components/icons/Pen.vue';

defineProps({
    id : Number,
});

</script>

<template>
    <Link :href="route('item.edit',id)" class="inline-block active:scale-[0.95] duration-300 translate-y-[6px] p-[6px] rounded-md bg-emerald-400 text-white shadow hover:opacity-90 me-2">
        <Pen />
    </Link>
</template>