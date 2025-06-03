<script setup>
import dashboardHeader from '../../Layouts/dashboardHeader.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';
import { computed, ref, watch, onMounted } from "vue";
import { debounce } from 'lodash';
import { router, useForm } from '@inertiajs/vue3'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
const props = defineProps({
    customers : Object,
    searchTerm : String,
})

const content = "allCustomers"


const getDate = (date) => 
    new Date(date).toLocaleDateString("en-us", {
        year : "numeric",
        month : "long",
        day : "numeric"
    })

const search = ref(props.searchTerm)

watch(search, debounce(
        (q) => {
            router.get('/allCustomers', {search: q}, {preserveState: true})
        },
        500
    )
)
</script>
<template>
    <Head>
        <title> | Dashboard</title>
        <meta head-key="Dashboard" name="Dashboard" content="Dashboard"/>
    </Head>
    <dashboardHeader :content="content">
        <template #main>
            <div class="h-[650px] flex flex-col items-center w-full bg-white text-black pt-[15px] divide-y-2 border-hBackground">
                <p class="text-[18px] pb-[10px]">All customers</p>
                <div class="w-full flex flex-col items-center pt-[15px]">
                    <div class="w-[80%] pt-[5px]">
                        <div class="flex justify-end mb-[10px] space-x-[2%]">
                            <input type="search" placeholder="Search" class="border-hBackground w-[20%] border-2 pl-[1%] h-[35px] rounded-[5px] focus:border-[#6b66a2] focus:outline-none"
                                v-model="search">
                        </div>
                        <table class="flex flex-col w-[100%] border-2 border-hBackground divide-y-2 divide-hBackground">
                        <thead class="">
                            <tr class="flex flex-row  h-[50px] w-[100%] divide-x-2 divide-hBackground">
                                <th class="flex items-center justify-center w-[20%]">ID</th>
                                <th class="flex items-center justify-center w-[20%]"><p>Name</p></th>
                                <th class="flex items-center justify-center w-[20%]">Username</th>
                                <th class="flex items-center justify-center w-[20%]">Email</th>
                                <th class="flex items-center justify-center w-[20%]">Created_at</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-hBackground">
                            <tr v-for="customer in customers.data" :key="customer.id" class="flex flex-row  h-[55px] w-[100%] divide-x-2 divide-hBackground text-[12px]">
                                <td class="flex items-center justify-center w-[20%] text-[14px]">{{ customer.id }}</td>
                                <td class="flex flex-col items-center justify-center w-[20%] text-[14px]">
                                    {{ customer.firstName }} {{ customer.surname }}
                                    <Link class="text-[#B00101]" :href="`/customerDetails/${customer.id}`">All details</Link>
                                </td>
                                <td class="flex items-center justify-center w-[20%] text-[14px]">{{ customer.username }}</td>
                                <td class="flex items-center justify-center w-[20%]" >{{ customer.email }}</td>
                                <td class="flex items-center justify-center w-[20%]">{{ getDate(customer.created_at) }}</td>
                            </tr>  
                        </tbody>
                        </table>
                        <div class="pt-2">
                            <PaginationLinks :paginator="customers"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </dashboardHeader>
    
</template>