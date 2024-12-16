<script setup>
import {Link } from '@inertiajs/vue3';
import Plus from '@/Components/icons/Plus.vue';

</script>

<template>
    <Link :href="route('item.create')" class="active:scale-[0.95] duration-300 flex justify-normal items-center gap-2 w-fit bg-theme text-white text-sm md:text-base px-3 py-[3px] md:px-5 md:py-[6px] rounded shadow-sm hover:opacity-90">
        <Plus />
        Add Item
    </Link>
</template>