<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-[94%] sm:max-w-md md:w-[400px] shadow-lg shadow-gray-200 rounded-lg px-1 py-2 pt-6 border border-gray-200">
            <div>
                <slot name="logo" />
            </div>

            <div class="w-full mt-2 px-4 md:px-6 py-4 bg-white overflow-hidden">
                <slot />
            </div>
        </div>
    </div>
</template>
