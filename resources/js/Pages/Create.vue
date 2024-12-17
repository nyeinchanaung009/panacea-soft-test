<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link,useForm } from '@inertiajs/vue3';
import ChevronRight from '@/Components/icons/ChevronRight.vue';
// import TextEditor from '@/Components/TextEditor.vue';
import LocationPicker from '@/Components/LocationPicker.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    categories: Object,
});

const form = useForm({
    name: '',
    category_id: '',
    price: null,
    description: '',
    condition: '',
    type: '',
    is_publish: true,
    image: null,
    owner: '',
    phone: '',
    address : ''
});

const handleFileChange = (event) => {
  form.image = event.target.files[0];
};


const submit = () => {
    form.post(route('item.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

</script>

<template>
    <AppLayout>
        <div class="mt-3 pt-4 px-2 md:px-4">
            <!-- breadcrumb -->
            <div class="flex gap-3 items-center">
                <Link :href="route('dashboard')" class="text-sm text-gray-600 font-bold">Items List</Link>
                <ChevronRight class="text-sm" />
                <Link :href="route('item.create')" class="text-sm text-theme font-bold">Add Items</Link>
            </div>

            <!-- title -->
            <div class="bg-secondary_bg rounded mt-6 px-4 py-2 mb-3">
                <p class="font-semibold text-primary_text">Add Items</p>
            </div>

            <!-- form -->
             <form  @submit.prevent="submit">
                 <div class="flex flex-col md:flex-row justify-start items-start gap-4 md:gap-0">
                    <!-- item information -->
                    <div class="w-full md:w-6/12 p-2">
                        <p class="font-bold text-primary_text">Item information</p>

                        <!-- itme name -->
                        <div class="mt-2 w-[95%] md:w-10/12 lg:w-9/12">
                            <div class="flex items-center justify-normal gap-2">
                                <InputLabel for="name" value="Name" />
                                <span class="text-red-500 translate-y-1 text-lg">*</span>
                            </div>
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="block w-full"
                                required
                                autocomplete="off"
                            />
                            <InputError class="-mt-1" :message="form.errors.name" />
                        </div>

                        <!-- category -->
                        <div class="my-3 w-[95%] md:w-10/12 lg:w-9/12">
                            <div class="flex items-center justify-normal gap-2">
                                <InputLabel for="category_id" value="Select Category" />
                                <span class="text-red-500 translate-y-1 text-lg">*</span>
                            </div>
                            <select name="category_id" id="category_id" v-model="form.category_id" class="w-full border-gray-300 rounded mt-2">
                                <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                            </select>
                            <InputError class="-mt-1" :message="form.errors.category_id" />
                        </div>

                        <!-- price -->
                        <div class="mt-4 w-[95%] md:w-10/12 lg:w-9/12">
                            <div class="flex items-center justify-normal gap-2">
                                <InputLabel for="price" value="Price" />
                                <span class="text-red-500 translate-y-1 text-lg">*</span>
                            </div>
                            <TextInput
                                id="price"
                                v-model="form.price"
                                type="number"
                                class="block w-full"
                                required
                                autocomplete="off"
                            />
                            <InputError class="-mt-1" :message="form.errors.price" />
                        </div>

                        <!-- description text editor -->
                        <div class="mt-2 w-[95%] md:w-10/12 lg:w-9/12">
                            <div class="flex items-center justify-normal gap-2">
                                <InputLabel for="description" value="Description" />
                                <span class="text-red-500 translate-y-1 text-lg">*</span>
                            </div>
                            <textarea v-model="form.description" class="w-full border-gray-300 rounded" rows="3"></textarea>
                            <!-- <TextEditor v-model="form.description" /> -->
                            <!-- class="bg-white rounded p-3 h-[25px] mt-1" -->
                            <InputError class="-mt-1" :message="form.errors.description" />
                        </div>

                        <!-- item condition -->
                        <div class="my-3 w-[95%] md:w-10/12 lg:w-9/12">
                            <div class="flex items-center justify-normal gap-2">
                                <InputLabel for="condition" value="Select Item Condition" />
                            </div>
                            <select name="condition" id="condition" v-model="form.condition" class="w-full border-gray-300 rounded mt-2">
                                <option value="new">New</option>
                                <option value="second hand">Second Hand</option>
                                <option value="display">Display</option>
                                <option value="damaged">Damaged</option>
                            </select>
                            <InputError class="-mt-1" :message="form.errors.condition" />
                        </div>

                        
                        <!-- item type -->
                        <div class="my-3 w-[95%] md:w-10/12 lg:w-9/12">
                            <div class="flex items-center justify-normal gap-2">
                                <InputLabel for="type" value="Select Item Type" />
                            </div>
                            <select name="type" id="type" v-model="form.type" class="w-full border-gray-300 rounded mt-2">
                                <option value="for sell">For Sell</option>
                                <option value="for buy">For Buy</option>
                                <option value="for exchange">For Exchange</option>
                            </select>
                            <InputError class="-mt-1" :message="form.errors.type" />
                        </div>

                        <!-- publish status -->
                        <div class="text-primary_text mt-4">
                            <InputLabel for="is_publish" value="Status" />
                            <div class="flex justify-normal items-center gap-3 ps-3">
                                <input type="checkbox" v-model="form.is_publish" class="mt-3 rounded" />
                                <span class="translate-y-[6px] text-sm">Publish</span>
                            </div>
                        </div>

                        <!-- item photo -->
                        <div class="mt-6">
                            <div class="flex items-center justify-normal gap-2">
                                <InputLabel for="image" value="Item Photo" />
                                <span class="text-red-500 translate-y-1 text-lg">*</span>
                            </div>
                            <p class="text-gray-600 text-xs">Recommended Size 400 x 200</p>
                            <!-- drag and drop -->
                             <input @change="handleFileChange" class="mt-3" type="file" />
                            <InputError class="-mt-1" :message="form.errors.image" />
                        </div>
                    </div>
                    <!-- owner information -->
                    <div class="w-full md:w-6/12 p-2">
                        <p class="font-bold text-primary_text">Owner information</p>

                        <!-- owner -->
                        <div class="mt-2 w-[95%] md:w-10/12 lg:w-9/12">
                            <div class="flex items-center justify-normal gap-2">
                                <InputLabel for="owner" value="Owner Name" />
                                <span class="text-red-500 translate-y-1 text-lg">*</span>
                            </div>
                            <TextInput
                                id="owner"
                                v-model="form.owner"
                                type="text"
                                class="block w-full"
                                required
                                autocomplete="off"
                            />
                            <InputError class="-mt-1" :message="form.errors.owner" />
                        </div>

                        <!-- contact number -->
                        <div class="mt-5 w-[95%] md:w-10/12 lg:w-9/12">
                            <InputLabel for="phone" value="Contact Number" />
                            <TextInput
                                id="phone"
                                v-model="form.phone"
                                type="text"
                                class="block w-full"
                                required
                                autocomplete="off"
                            />
                            <InputError class="-mt-1" :message="form.errors.phone" />
                        </div>

                        <!-- address -->
                        <div class="mt-5 w-[95%] md:w-10/12 lg:w-9/12">
                            <InputLabel for="address" value="Address" />
                            <LocationPicker v-model="form.address" />
                            <InputError class="-mt-1" :message="form.errors.address" />
                        </div>

                        <!-- <LocationPicker/> -->
                    </div>
                </div>
                <div class="flex justify-end items-center gap-6 mr-5 mt-3 md:pe-7">
                    <Link :href="route('dashboard')" class="px-6 py-[6px] rounded hover:bg-secondary_bg active:scale-[0.95] duration-300">Cancel</Link>
                    <button @click="submit" type="submit" class="bg-theme text-white px-6 py-[6px] rounded active:scale-[0.95] duration-300">Save</button>
                </div>
             </form>
            
        </div>
    </AppLayout>
</template>