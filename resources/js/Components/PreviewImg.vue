<script setup>
import Upload from '@/Components/icons/Upload.vue';

defineProps({
    selectedImg : String,
});
</script>

<template>
    <label for="image" class="block w-[95%] md:w-10/12 lg:w-9/12 mt-4 cursor-pointer hover:scale-[0.99] hover:opacity-80 duration-200">
        <img v-if="selectedImg" :src="selectedImg" class="w-[250px] md:w-[300px] border border-gray-400 mt-2 rounded" alt="img" />
        <div v-else class="bg-white w-full border-2 border-theme dark:border-gray-400 rounded-md flex flex-col gap-2 p-8 justify-center items-center text-theme font-bold text-lg">
            <Upload class="text-2xl mb-2" />
            <span>Choose Image</span>
        </div>
    </label>
</template>