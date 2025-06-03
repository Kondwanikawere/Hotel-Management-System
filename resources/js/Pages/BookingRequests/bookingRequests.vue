<script setup>
import dashboardHeader from '../../Layouts/dashboardHeader.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';

const props = defineProps({
    bookingRequests : Object,
})

const getDate = (date) => 
    new Date(date).toLocaleDateString("en-us", {
        year : "numeric",
        month : "long",
        day : "numeric",
        hour: "numeric",
        minute: "numeric",
        second: "numeric"
    })


</script>
<template>
    <Head>
        <title> | Dashboard</title>
        <meta head-key="Dashboard" name="Dashboard" content="Dashboard"/>
    </Head>
    <dashboardHeader :content="content">
        <template #main>
            <div class="h-[650px] flex flex-col items-center w-full bg-white text-black pt-[15px] divide-y-2 border-hBackground">
                <p class="text-[18px] pb-[10px]">Booking Requests</p>
                <div class="w-full flex flex-col items-center pt-[15px]">
                    <div class="w-[80%] pt-[5px]">
                        <table class="flex flex-col w-[100%] border-2 border-hBackground divide-y-2 divide-hBackground">
                        <thead class="">
                            <tr class="flex flex-row  h-[50px] w-[100%] divide-x-2 divide-hBackground">
                                <th class="flex items-center justify-center w-[25%]">Request ID</th>
                                <th class="flex items-center justify-center w-[25%]"><p>Name</p></th>
                                <th class="flex items-center justify-center w-[25%]">Request created_at</th>
                                <th class="flex items-center justify-center w-[25%]">Request status</th>
                                <th class="flex items-center justify-center w-[25%]"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-hBackground">
                            <tr v-for="bookingRequest in bookingRequests.data" :key="bookingRequest.id" class="flex flex-row  h-[55px] w-[100%] divide-x-2 divide-hBackground text-[12px]">
                                <td class="flex items-center justify-center w-[25%] text-[14px]">{{ bookingRequest.Id }}</td>
                                <td class="flex flex-col items-center justify-center w-[25%] text-[14px]">
                                    {{ bookingRequest.customer.firstName }} {{ bookingRequest.customer.surname }}
                                    <Link class="text-[#B00101]" :href="`/customerDetails/${bookingRequest.customer.id}`">
                                        All details
                                    </Link>
                                </td>
                                <td class="flex items-center justify-center w-[25%] text-[14px]">{{ getDate(bookingRequest.created_at) }}</td>
                                <td class="flex items-center justify-center w-[25%]">
                                    <div v-if="bookingRequest.status === null">
                                            Null
                                    </div>
                                    <div v-else>
                                        {{ bookingRequest.status }}
                                    </div>
                                </td>
                                <td class="flex items-center justify-center w-[25%]">
                                    <Link :href="`/acceptBookingRequest/${bookingRequest.Id}/${bookingRequest.customer.id}`"  class="flex justify-center w-[50%] h-[60%] text-white items-center rounded-[5px] text-[13px] bg-greenColor">Accept</Link>
                                </td>
                                
                            </tr>  
                        </tbody>
                        </table>
                        <div class="pt-2">
                            <PaginationLinks :paginator="bookingRequests"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </dashboardHeader>
    
</template>