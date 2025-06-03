<script setup>
import dashboardHeader from '../../Layouts/dashboardHeader.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';
import { computed, ref, watch, onMounted } from "vue";
import { router, useForm } from '@inertiajs/vue3'
import { throttle } from 'lodash';
import { debounce } from 'lodash';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

const props = defineProps({
    rooms : Object,
    searchTerm : String,
    FilterSelection : Object,
})

const content = "allRooms"

const getRoomType = (type) => {
    const typeMapping = {
        F : "Family",
        S : "Single",
        E : "Executive",
        B : "Bridal",
        T : "Twin"
    }
    return typeMapping[type] || "Unknown"
}
const getRoomStatus = (status) => {
    const statusMapping = {
        0 : "Vacant",
        1 : "Booked"
    }
    return statusMapping[status] || "Not clear"
}
const getDate = (date) => 
    new Date(date).toLocaleDateString("en-us", {
        year : "numeric",
        month : "long",
        day : "numeric"
    })

const search = ref(props.searchTerm)

watch(search, debounce(
        (q) => {
            form.bridal = null;
            form.single =  null;
            form.twin =  null;
            form.family =  null;
            form.executive =  null;
            router.get('/rooms', {search: q}, {preserveState: true})
        },
        500
    )
)

const form = useForm({
        twin : null,
        family : null,
        executive : null,
        bridal : null,
        single : null,
    })

    const submit = () => {
        form.get(route('allRooms'));
    }

    onMounted(() => {
        form.bridal = props.FilterSelection?.bridal || null;
        form.single = props.FilterSelection?.single || null;
        form.twin = props.FilterSelection?.twin || null;
        form.family = props.FilterSelection?.family || null;
        form.executive = props.FilterSelection?.executive || null;
    });

</script>
<template>
    <Head>
        <title> | Dashboard</title>
        <meta head-key="Dashboard" name="Dashboard" content="Dashboard"/>
    </Head>
    <dashboardHeader :content="content">
        <template #main>
            <div class="h-[650px] flex flex-col items-center w-full bg-white text-black pt-[15px] divide-y-2 border-hBackground">
                <p class="text-[18px] pb-[10px]">All rooms</p>
                <div class="w-full flex flex-col items-center pt-[15px]">
                    <div class="w-[80%] pt-[5px]">

                        <div class="flex justify-end mb-[10px] space-x-[2%]">
                            <input type="search" placeholder="Search room Id" class="border-hBackground w-[20%] border-2 pl-[1%] h-[35px] rounded-[5px] focus:border-[#6b66a2] focus:outline-none"
                                v-model="search">
                            <Menu as="div">
                                <div>
                                    <MenuButton class="inline-flex w-full justify-center">
                                        <img src="/public/images/filter.svg" alt="filter" class="w-[30px] h-[30px]">
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems class="absolute rounded-md shadow-lg ring-1 ring-black/5 w-[10%] bg-white pl-[1%] pt-[10px]">
                                        <div class="py-1">
                                            <form @submit.prevent ="submit" class="flex flex-col">
                                                <div class="flex gap-x-[5%]">
                                                    <input type="checkbox" id="bridal" value="B" v-model="form.bridal" :true-value="'B'" :false-value="null">
                                                    <label for="bridal">Bridal</label>
                                                </div>
                                                <div class="flex gap-x-[5%]">
                                                    <input type="checkbox" id="single" value="S" v-model="form.single" :true-value="'S'" :false-value="null">
                                                    <label for="single">Single</label>
                                                </div>
                                                <div class="flex gap-x-[5%]">
                                                    <input type="checkbox" id="twin" value="T" v-model="form.twin" :true-value="'T'" :false-value="null">
                                                    <label for="twin">Twin</label>
                                                </div>
                                                <div class="flex gap-x-[5%]">
                                                    <input type="checkbox" id="family" value="F" v-model="form.family" :true-value="'F'" :false-value="null">
                                                    <label for="family">Family</label>
                                                </div>
                                                <div class="flex gap-x-[5%]">
                                                    <input type="checkbox" id="executive" value="E" v-model="form.executive" :true-value="'E'" :false-value="null">
                                                    <label for="executive">Executive</label>
                                                </div>
                                                <MenuItem as="div" class="flex w-[80%] justify-center pt-[10px] pb-[10px]">
                                                    <button type="submit" class="bg-[#02703B] w-[60%] rounded-[5px] flex items-center justify-center text-white" :disabled="form.processing">Filter</button>
                                                </MenuItem>
                                            </form>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>

                        <table class="flex flex-col w-[100%] border-2 border-hBackground divide-y-2 divide-hBackground">
                            <thead class="">
                                <tr class="flex flex-row  h-[50px] w-[100%] divide-x-2 divide-hBackground">
                                    <th class="flex items-center justify-center w-[25%]">Room number</th>
                                    <th class="flex items-center justify-center w-[25%]"><p>Type</p></th>
                                    <th class="flex items-center justify-center w-[25%]">Status</th>
                                    <th class="flex items-center justify-center w-[25%]">CustomerId</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2 divide-hBackground">
                                <tr v-for="room in rooms.data" :key="room.id" class="flex flex-row  h-[35px] w-[100%] divide-x-2 divide-hBackground">
                                    <td class="flex items-center justify-center w-[25%]">{{ room.id }}</td>
                                    <td class="flex items-center justify-center w-[25%]">{{ getRoomType(room.type) }}</td>
                                    <td class="flex items-center justify-center w-[25%]" >
                                        <div class="flex justify-center w-[35%] h-[80%] text-white items-center rounded-[5px] text-[13px]" :class="{'bg-[#B00101]' : room.status === 0, 'bg-[#02703B]' : room.status === 1}">{{ getRoomStatus(room.status) }}</div>
                                    </td>
                                    <td class="flex items-center justify-center w-[25%]">
                                        <div v-if="room.status === 1">
                                            {{ room.latest_customer_visit.customerId }}
                                        </div>
                                    </td>
                                </tr>  
                            </tbody>
                        </table>
                        <div class="pt-2">
                            <PaginationLinks :paginator="rooms"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </dashboardHeader>
    
</template>