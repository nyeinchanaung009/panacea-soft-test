<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Eye from '@/Components/icons/Eye.vue';
import EyeSlash from '@/Components/icons/EyeSlash.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div>
        <Head title="Log in" />

        <AuthenticationCard>
            <template #logo>
                <AuthenticationCardLogo />
                <div class="mt-3 text-center text-neutral-800 font-bold text-lg md:text-2xl">
                    Login to your account
                </div>
                <div class="text-sm md:text-[15px] text-gray-500 font-medium text-center mt-1">
                    Welcome Back !
                </div>
            </template>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        class="mt-1 block w-full"
                        type="email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder_name="enter email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
                    <div class="relative">
                        <TextInput
                        id="password"
                        v-model="form.password"
                        class="mt-1 block w-full"
                        :type="showPassword ? 'text' : 'password'"
                        required
                        autocomplete="current-password"
                        placeholder_name="enter password"
                        />
                        <button type="button" @click="showPassword = !showPassword" class="hover:opacity-80 rounded-full p-2 absolute right-[8px] top-1 text-lg text-gray-500 dark:text-gray-700">
                            <component :is="showPassword ? Eye : EyeSlash" />
                        </button>
                    </div>
                    
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-6">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Sign In
                    </PrimaryButton>
                    <div class="flex justify-end">
                        <Link :href="route('register')" class="mt-3 inline-block underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            registered here
                        </Link>    
                    </div>
                </div>
            </form>
        </AuthenticationCard>
    </div>
</template>
