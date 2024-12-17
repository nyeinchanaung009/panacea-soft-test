<script setup>
import { onMounted, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Grid from '@/Components/icons/Grid.vue';
import Logout from '@/Components/icons/Logout.vue';
import Menu from '@/Components/icons/Menu.vue';
import Close from '@/Components/icons/Close.vue';
import DarkMode from '@/Components/DarkMode.vue';

defineProps({
    title: String,
});

const navOpen = ref(false);

const logout = () => {
    router.post(route('logout'));
};

</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="w-full h-screen flex">
            <!-- side bar -->
            <div :class="navOpen ? 'translate-x-0 absolute md:fixed' : '-translate-x-full absolute'" class="z-50 bg-secondary_bg h-screen w-[270px] lg:w-[300px] xl:w-[320px] duration-300 shadow-md">
                <div class="h-full relative pt-9 px-6">
                    <button @click="navOpen = !navOpen" class="md:hidden hover:bg-gray-300 p-[6px] rounded absolute right-0 top-2">
                        <Close class="text-xl text-gray-600 dark:text-gray-400" />
                    </button>
                    <div class="flex justify-start items-center gap-5">
                        <a href="/">
                            <img src="/images/ps logo blue.png" class="w-[40px] rounded-md" alt="logo" />
                        </a>
                        <h4 class="font-bold text-primary_text text-xl">Admin Panel</h4>
                    </div>
                    <div class="mt-9">
                        <!-- navlink -->
                        <Link :href="route('dashboard')" :class="route().current() == 'dashboard' || 'item' ? 'bg-theme text-white' : 'bg-white text-primary_text'" class="flex justify-start items-center gap-3 w-full px-4 py-[10px] rounded-md shadow-sm hover:opacity-90">
                            <Grid class="text-lg"/>
                            Items
                        </Link>
                    </div> 

                    <!-- logout -->
                    <form @submit.prevent="logout">
                        <button class="absolute bottom-10 left-4 text-primary_text font-medium text-sm p-4 hover:opacity-80 flex justify-start items-center gap-3">
                            <Logout class="text-base" />
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <div :class="navOpen ? 'md:ml-[270px] lg:ml-[300px] xl:ml-[320px]' : ''" class="bg-primary_bg h-full flex-1 duration-300">
                <!-- option bar -->
                <div class="sticky top-0 z-20 bg-primary_bg py-2">
                    <div class="flex justify-between items-center ps-2 md:ps-3 pe-8">
                        <button @click="navOpen = !navOpen" class="hover:bg-secondary_bg p-[6px] rounded">
                            <component class="text-[22px] text-gray-600 dark:text-gray-400" :is="navOpen ? Close : Menu" />
                        </button>
                        <DarkMode />
                    </div>
                </div>
                <div class="pb-24 px-2 pt-0">
                    <!-- main content -->
                    <slot />
                </div>

                <!-- footer -->
                <footer class="py-3 bg-secondary_bg text-center text-sm">
                    <a class="text-slate-600 p-1" target="_blank" href="https://nyeinchanaung009.pages.dev">
                        Developed by Nyein Chan Aung | 
                        <span class="text-theme font-bold">Portfolio</span>
                    </a>
                </footer>
            </div>
        </div>
    </div>
</template>
