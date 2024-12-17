<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link,useForm } from '@inertiajs/vue3';
import ChevronRight from '@/Components/icons/ChevronRight.vue';
// import TextEditor from '@/Components/TextEditor.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import LocationPicker from '@/Components/LocationPicker.vue';
import PreviewImg from '@/Components/PreviewImg.vue';
import { ref } from 'vue';


const { item, categories } = defineProps({
    item: Object,
    categories: Object,
});

const selectedImg = ref(item.image != null ? '/storage/'+item.image : null);

const form = useForm({
    name : item?.name,
    category_id : item?.category_id,
    price : item?.price,
    description : item?.description,
    condition : item?.condition,
    type : item?.type,
    is_publish : item?.is_publish,
    image : null,
    owner : item?.owner,
    phone : item?.phone,
    address : item?.address
});

const handleFileChange = (event) => {
  form.image = event.target.files[0];
  
  if(event.target.files.length > 0){
        selectedImg.value = URL.createObjectURL(event.target.files[0]);
  }else{
        selectedImg.value = null;
  }
};


const submit = () => {

    // const formData = new FormData();
    
    form.post(route('item.update',item.id), {
        onSuccess: () => console.log('Form updated successfully'),
        onError: (errors) => console.error('Errors:', errors),
    });
};

</script>

<template>
    <AppLayout>
        <div class="mt-3 pt-4 px-2 md:px-4">
            <!-- breadcrumb -->
            <div class="flex gap-3 items-center">
                <Link :href="route('dashboard')" class="text-sm text-gray-600 dark:text-gray-400 font-bold">Items List</Link>
                <ChevronRight class="text-sm text-gray-600 dark:text-gray-400" />
                <Link :href="route('item.edit',item.id)" class="text-sm text-theme font-bold">Update Items</Link>
            </div>

            <!-- title -->
            <div class="bg-secondary_bg rounded mt-6 px-4 py-2 mb-3">
                <p class="font-semibold text-primary_text">Update Items</p>
            </div>

            <!-- form -->
             <form  @submit.prevent="submit" enctype="multipart/form-data">
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
                            <p class="text-gray-600 dark:text-gray-400 text-xs">Recommended Size 400 x 200</p>
                            <!-- drag and drop -->
                             <input id="image" @change="handleFileChange" class="mt-3 hidden" type="file" />
                            <InputError class="-mt-1" :message="form.errors.image" />
                        </div>

                        <PreviewImg :selectedImg="selectedImg" />
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

                        <!-- contact phone -->
                        <div class="mt-5 w-[95%] md:w-10/12 lg:w-9/12">
                            <InputLabel for="phone" value="Contact Number" />
                            <TextInput
                                id="phone"
                                v-model="form.phone"
                                type="number"
                                class="block w-full mt-2"
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
                    </div>
                </div>

                <div class="flex justify-end items-center gap-6 mr-5 mt-7 pe-12">
                    <Link :href="route('dashboard')" class="px-10 py-[6px] rounded hover:bg-gray-300 active:scale-[0.95] duration-300 bg-secondary_bg text-gray-700 dark:text-gray-300">Cancel</Link>
                    <button @click="submit" type="submit" class="bg-theme text-white px-10 py-[6px] rounded active:scale-[0.95] duration-300">Update</button>
                </div>
             </form>
            
        </div>
    </AppLayout>
</template>