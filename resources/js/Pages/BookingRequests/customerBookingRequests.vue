<script setup>
import dashboardHeader from '../../Layouts/customerDashboardHeader.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';
import { computed, onMounted } from "vue";
import dayjs from 'dayjs';
import { router, useForm } from '@inertiajs/vue3'
import FlatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'

const props = defineProps({
    rooms : Object,
    customerDetails : Object,
    bookingRequests : Object,
    vacantRooms : Object
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
const getRequeststatus = (status) => {
    const statusMapping = {
        0 : "Denied",
        1 : "Accepted"
    }
    return statusMapping[status] || "Not clear"
}
const getDate = (date) => 
    new Date(date).toLocaleDateString("en-us", {
        year : "numeric",
        month : "long",
        day : "numeric",
        hour: "numeric",
        minute: "numeric",
        second: "numeric"
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

const form = useForm({
        checkIn : null,
        checkOut : null,
        roomType : null,
    })

const submit = () => {
    form.get(route('SendRoomBookingRequest'))
}

const config = {
  enableTime: true,
  dateFormat: 'Y-m-d H:i',
  time_24hr: true
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
                <div class="w-full flex items-center pl-[40%] space-x-[68%] pb-[px]">
                    <p class="text-[18px] justify-self-center">Room booking</p>
                </div>
                <div class="w-[100%] mt-[10px] flex flex-col items-center pt-[10px]">
                    <div class="w-full flex flex-col items-center ">
                        <form  class="w-full" @submit.prevent ="submit">
                            <div class="flex justify-center w-full space-x-[8%] pt-[20px]">
                                <div class="flex flex-col w-[15%] space-y-[7px]">
                                    <p>Select Room Type</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        <select v-model="form.roomType">
                                            <option value="S">Single</option>
                                            <option value="T">Twin</option>
                                            <option value="B">Bridal</option>
                                            <option value="F">Family</option>
                                            <option value="E">Executive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex flex-col w-[20%] space-y-[7px]">
                                    <p>CheckIn</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        <flat-pickr v-model="form.checkIn" :config="config" placeholder="Choose Date & Time"/>
                                    </div>
                                </div>
                                <div class="flex flex-col w-[20%] space-y-[7px]">
                                    <p>Checkout</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        <flat-pickr v-model="form.checkOut":config="config" placeholder="Choose Date & Time"/>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center w-full space-x-[8%] pt-[20px]">
                                <div class="flex flex-col w-[10%] space-y-[7px]">
                                    <button class="border-2 bg-greenColor text-white rounded-[5%] flex justify-center items-center h-[40px]"  :disabled="form.processing">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="w-[100%] mt-[10px] flex flex-col items-center pt-[10px]">
                    <div class="w-full flex flex-col items-center ">
                        <table class="flex flex-col w-[90%] border-2 border-hBackground divide-y-2 divide-hBackground">
                        <thead class="">
                            <tr class="flex flex-row  h-[50px] w-[100%] divide-x-2 divide-hBackground">
                                <th class="flex items-center justify-center w-[10%]">Request ID</th>
                                <th class="flex items-center justify-center w-[25%]">Request_created_on</th>
                                <th class="flex items-center justify-center w-[15%]">For type</th>
                                <th class="flex items-center justify-center w-[10%]"><p>Status</p></th>
                                <th class="flex items-center justify-center w-[40%]">Allocation</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-hBackground">
                            <tr v-for="bookingRequest in bookingRequests.data" :key="bookingRequest.id" class="flex flex-row  h-[70px] w-[100%] divide-x-2 divide-hBackground text-[12px]">
                                <td class="flex items-center justify-center w-[10%] text-[14px]">{{ bookingRequest.Id }}</td>
                                <td class="flex items-center justify-center w-[25%] text-[14px]">{{ getDate(bookingRequest.created_at) }}</td>
                                <td class="flex items-center justify-center w-[15%] text-[14px]">{{ getRoomType(bookingRequest.roomType) }}</td>
                                <td class="flex flex-col items-center justify-center w-[10%] text-[14px]">
                                    <div v-if="bookingRequest.status === 1 || bookingRequest.status === 0" class="flex justify-center w-[60%] h-[35px] text-white items-center rounded-[5px] text-[13px]" :class="{'bg-[#B00101]' : bookingRequest.status === 0, 'bg-[#02703B]' : bookingRequest.status === 1}">{{ getRequeststatus(bookingRequest.status) }}</div>
                                    <div v-if="bookingRequest.status === null" class="flex justify-center w-[60%] h-[35px] text-white items-center rounded-[5px] text-[13px] bg-[#02703B]">Pending</div>
                                </td>
                                <td class="flex items-center justify-center w-[40%] text-[14px]">
                                    <div v-if="bookingRequest.status === 0" class="w-[90%] flex flex-col  items-center">
                                        <p>
                                        We regret to inform you that all the <i class="text-redColor">{{ getRoomType(bookingRequest.roomType) }} </i> rooms are unavailable at the moment. Please consider other selections.
                                        </p>
                                    </div>
                                    <div v-if="bookingRequest.status === 1" class="w-[90%] flex flex-col  items-center">
                                        <p>
                                            You have successfully booked a <i class="text-redColor">{{ getRoomType(bookingRequest.roomType) }} </i> room. Your room number is <i class="text-redColor">{{ bookingRequest.customer_visit.roomId }}</i>.
                                            Your check-in day is <span class="text-redColor"> {{ getDate(bookingRequest.checkIn) }}</span>.
                                        </p>
                                    </div>
                                </td>
                            </tr>  
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </template>
    </dashboardHeader>
</template>