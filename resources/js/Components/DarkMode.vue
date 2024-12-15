<script setup>
import { onMounted, ref } from 'vue';
import Moon from '@/Components/icons/Moon.vue';
import Sun from '@/Components/icons/Sun.vue';

const isDarkMode = ref(localStorage.getItem('theme') === 'dark');

const applyTheme = () => {
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
};

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
  applyTheme();
};

onMounted(()=>{
    // const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    // const savedTheme = localStorage.getItem('theme');
    // isDarkMode.value = savedTheme ? savedTheme === 'dark' : systemPrefersDark;
    applyTheme();
})

</script>

<template>
    <div>
        <button @click="toggleDarkMode" class="p-2 rounded">
            <component class="text-2xl text-theme" :is="isDarkMode ? Sun : Moon" />
        </button>
    </div>
</template>
