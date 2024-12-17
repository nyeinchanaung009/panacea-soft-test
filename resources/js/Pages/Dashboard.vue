<script setup>
import {Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import AddButton from '@/Components/AddButton.vue';
import EditButton from '@/Components/EditButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import NoData from '@/Components/NoData.vue';
import ChevronDown from '@/Components/icons/ChevronDown.vue';
import Trash from '@/Components/icons/Trash.vue';

const props = defineProps({
    items: Object,
    row : Number
});

const itemsData = ref(props.items);
const showConfirmDelete = ref(false);
const itemToDelete = ref(null);

function filterLabel(label){
    if(label === '&laquo; Previous') {
        label = '&laquo;';
    }else if(label === 'Next &raquo;') {
        label = '&raquo;';
    };
    return label;
}

const publishToggle = (item) => {
    axios.post(route('item.makePublish'), {
        id: item.id,
    }).then(() => {        
        item.is_publish = !item.is_publish;
    }).catch(error => {
        //
    });
};

const deleteItem = (id) => {
  itemToDelete.value = id;
  showConfirmDelete.value = true;
};

const confirmDelete = async () => {
  try {
    const response = await axios.delete(route("item.destroy", itemToDelete.value));

    if (response.data.success) {
        showConfirmDelete.value = false;

        // itemsData.value.data = itemsData.value.data.filter((item) => item.id != itemToDelete.value);
        
        const itemIndex = itemsData.value.data.findIndex(item => item.id === itemToDelete.value);
        if (itemIndex !== -1) {
            itemsData.value.data.splice(itemIndex, 1); // Remove item from the list
        }
        itemToDelete.value = null;
    }
  } catch (error) {
    //
  }
};

const cancelDelete = () => {
    itemToDelete.value = null;
    showConfirmDelete.value = false;
}

const parentOnDelete = (event) => {
    if (event.target === event.currentTarget) {
        cancelDelete();
    }
}

</script>

<template>
    <!-- delete confirmation model -->
    <div @click="parentOnDelete" v-if="showConfirmDelete" class="parent w-full h-screen fixed top-0 left-0 z-[200] bg-gray-600/80 backdrop-blur-[2px] text-white flex justify-center items-center">
        <div class="w-[270px] py-7 bg-primary_bg text-primary_text rounded-md text-center">
            <Trash class="text-5xl mx-auto mb-6" />
            <p class="text-xl leading-5 font-bold">Confirm Delete</p>
            <span class="text-gray-500 dark:text-gray-400 text-sm">Are you sure to delete ?</span>
            <div class="flex justify-center gap-4 mt-7">
                <button @click="cancelDelete" class="active:scale-[0.95] duration-[200] bg-secondary_bg dark:bg-slate-700 text-gray-500 dark:text-gray-400 px-4 py-1 rounded hover:bg-slate-300 dark:hover:bg-slate-600">
                    Cancel
                </button>
                <button @click="confirmDelete" class="active:scale-[0.95] duration-[200] text-white bg-red-500/90 px-4 py-1 rounded shadow hover:opacity-90">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <AppLayout title="Dashboard">
        <div class="mt-3 pt-4 px-2 md:px-4">
            <!-- breadcrumb -->
            <div>
                <Link :href="route('dashboard')" class="text-sm text-theme font-bold">Items List</Link>
            </div>

            <!-- add button -->
            <div class="mt-6 flex justify-end items-center pe-2 md:pe-5">
                <AddButton />
            </div>

            <!-- row selector -->
            <div class="mt-5">
                <div class="flex w-fit gap-3 text-gray-700 dark:text-gray-400 cursor-pointer group">
                    <span class="font-bold">Show : </span>
                    <div class="relative z-20    w-[120px] text-center border border-gray-400 dark:border-gray-600 py-1 rounded-md text-sm">
                        <div class="flex justify-evenly items-center">
                            <span>{{ row }} rows</span>
                            <ChevronDown />
                        </div>
                        <div class="hidden absolute w-full group-hover:flex flex-col left-0 top-[28px] bg-secondary_bg rounded-b-md border border-gray-400 dark:border-gray-600">
                            <Link v-for="r in [10,20,30,50,70,100]" :key="r" :href="route('dashboard',{row:r})" :class="row == r ? 'bg-theme text-white hover:text-theme' : ''" class="hover:bg-white dark:hover:bg-black/30 py-2">{{ r }} rows</Link>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- item data table -->
            <div class="w-[95vw] md:w-full overflow-x-auto py-8">
                <table class="w-full text-left">
                    <thead class="bg-theme text-white text-bold">
                        <tr>
                            <th class="ps-12 pe-3 py-[6px]">
                                Action
                            </th>
                            <th class="px-3 py-[6px]">
                                No
                            </th>
                            <th class="px-3 py-[6px]">
                                Item Name
                            </th>
                            <th class="px-3 py-[6px]">
                                Category
                            </th>
                            <th class="px-3 py-[6px]">
                                Description
                            </th>
                            <th class="px-3 py-[6px]">
                                Price
                            </th>
                            <th class="px-3 py-[6px]">
                                Owner
                            </th>
                            <th class="ps-3 pe-[12px] py-[6px]">
                                Publish
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="itemsData.data.length > 0" class="text-primary_text text-[14.5px]">
                        <tr v-for="(item,index) in itemsData.data" :key="item.id" class="border-b border-slate-300 dark:border-slate-600">
                            <td class="ps-12 pe-3 py-3">
                                <div>
                                    <EditButton :id="item.id"  />
                                    <DeleteButton @click="deleteItem(item.id)" class="mt-1 lg:mt-0" />
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                {{ itemsData.from + index }}
                            </td>
                            <td class="px-3 py-3">
                                {{ item.name }}
                            </td>
                            <td class="px-3 py-3">
                                {{ item.category.name }}
                            </td>
                            <td class="px-3 py-3">
                                {{ item.description.substring(0,18) }}...
                            </td>
                            <td class="px-3 py-3">
                                ${{ item.price }}
                            </td>
                            <td class="px-3 py-3">
                                {{ item.owner }}
                            </td>
                            <td class="px-3 py-3">
                                <!-- switch -->
                                 <div @click="publishToggle(item)" :class="item.is_publish ? 'bg-theme' : 'bg-gray-400'" class="relative w-[34px] h-[18px] rounded-full cursor-pointer">
                                    <div :class="item.is_publish ? 'translate-x-[85%]' : 'translate-x-0'" class="absolute top-0 w-[18px] h-[18px] hover:opacity-80 rounded-full bg-gray-100 border border-gray-400 dark:border-gray-500 duration-300">
                                    </div>
                                 </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="itemsData.data.length < 1">
                    <NoData />
                </div>
            </div>

            <!-- pagination -->
            <div v-if="itemsData.data.length > 0" class="flex flex-col md:flex-row justify-between items-center gap-4 pb-12 pe-3 md:px-5 lg:px-8">
                <div class="text-gray-600 dark:text-gray-400 text-[15px]">
                     Showing {{ itemsData.from }} to {{ itemsData.to }} of {{ itemsData.total }} entries
                </div>
                <div class="flex justify-center items-center gap-2">
                    <Link v-for="link in itemsData.links" :key="link.url" :href="link.url" :class="link.active ? 'bg-theme text-white' : 'bg-primary_bg text-primary_text border border-gray-300 dark:border-gray-700'" class="px-[10px] py-[2px] shadow" v-html="filterLabel(link.label)" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
