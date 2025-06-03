<script setup>
import dashboardHeader from '../../Layouts/customerDashboardHeader.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';
import { computed } from "vue";
import dayjs from 'dayjs';
const props = defineProps({
    rooms : Object,
    customerDetails : Object,
    customerVisits : Object
})

const content = "vacantRooms"

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

const diffInDays = (date1, date2) =>{
    const d1 = dayjs(date1)
    const d2 = dayjs(date2)
    return d1.diff(d2, 'day') 
}
const remainingDays = (date2) =>{
    const d1 = dayjs(date1)
    return now.diff(d2, 'day') 
}
</script>

<template>
    <Head>
        <title> | Dashboard</title>
        <meta head-key="Dashboard" name="Dashboard" content="Dashboard"/>
    </Head>
    <dashboardHeader :content="content">
        <template #main>
            <div class="h-[650px] flex flex-col items-center w-full bg-white text-black pt-[15px] divide-y-2 border-hBackground">
                <div class="w-full flex items-center pl-[40%] space-x-[68%] pb-[10px]">
                    <p class="text-[18px] justify-self-center">My details</p>
                    <Link :href="route('editMyProfile')" class="bg-[#02703B] w-[70px] flex justify-center items-center h-[30px] rounded-[5px] text-white">Edit</Link>
                </div>
                <div class="w-full flex flex-col items-center pt-[25px]">
                    <div class="flex justify-center w-full space-x-[8%]">
                        <div class="flex flex-col w-[15%] space-y-[7px]">
                            <p>Firstname</p>
                            <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                {{ customerDetails.firstName }}
                            </div>
                        </div>
                        <div class="flex flex-col w-[15%] space-y-[7px]">
                            <p>Surname</p>
                            <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                {{ customerDetails.surname }}
                            </div>
                        </div>
                        <div class="flex flex-col w-[20%] space-y-[7px]">
                            <p>Email</p>
                            <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                {{ customerDetails.email }}
                            </div>
                        </div>
                        <div class="flex flex-col w-[15%] space-y-[7px]">
                            <p>Username</p>
                            <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                {{ customerDetails.username }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-[100%] mt-[30px] flex flex-col items-center pt-[30px]">
                    <table class="flex flex-col w-[90%] border-2 border-hBackground divide-y-2 divide-hBackground">
                        <thead class="">
                            <tr class="flex flex-row  h-[50px] w-[100%] divide-x-2 divide-hBackground">
                                <th class="flex items-center justify-center w-[16%]">Room Number</th>
                                <th class="flex items-center justify-center w-[16%]"><p>Arrival time</p></th>
                                <th class="flex items-center justify-center w-[16%]">Valid until</th>
                                <th class="flex items-center justify-center w-[16%]">No. of days</th>
                                <th class="flex items-center justify-center w-[16%]">remaining days</th>
                                <th class="flex items-center justify-center w-[16%]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-hBackground">
                            <tr v-for="customerVisit in customerVisits.data" :key="customerVisit.id" class="flex flex-row  h-[55px] w-[100%] divide-x-2 divide-hBackground text-[12px]">
                                <td class="flex items-center justify-center w-[16%] text-[14px]">{{ customerVisit.roomId }}</td>
                                <td class="flex flex-col items-center justify-center w-[16%] text-[14px]">
                                   {{ getDate(customerVisit.checkIn) }}
                                </td>
                                <td class="flex items-center justify-center w-[16%] text-[14px]">{{ getDate(customerVisit.checkOut) }}</td>
                                <td class="flex items-center justify-center w-[16%]" >{{ diffInDays(customerVisit.checkOut, customerVisit.checkIn) }}</td>
                                <td class="flex items-center justify-center w-[16%]" >
                                    <div v-if="diffInDays(customerVisit.checkOut) < 0 ">
                                        0
                                    </div>
                                    <div v-else>
                                        {{ diffInDays(customerVisit.checkOut) }} 
                                    </div>
                                </td>
                                <td class="flex items-center justify-center w-[16%]">
                                    <div v-if="diffInDays(customerVisit.checkOut) > 0 && customerVisit.status === 1" class="flex justify-center w-[50%] h-[60%] text-white items-center rounded-[5px] text-[13px] bg-greenColor">
                                        Active
                                    </div>
                                    <div v-else class="flex justify-center w-[40%] h-[60%] text-white items-center rounded-[5px] text-[13px] bg-redColor">
                                        Inactive
                                    </div>
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                    <div class="pt-2 w-[90%]">
                        <PaginationLinks :paginator="customerVisits"/>
                    </div>
                </div>
            </div>
        </template>
    </dashboardHeader>
</template>