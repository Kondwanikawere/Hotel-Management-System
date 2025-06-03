<script setup>
import dashboardHeader from '../../Layouts/dashboardHeader.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';
import { computed, onMounted } from "vue";
import dayjs from 'dayjs';
import { router, useForm } from '@inertiajs/vue3'
import FlatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'

const props = defineProps({
    rooms : Object,
    customerDetails : Object,
    bookingRequest : Object,
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
        roomId : null,
    })

const submit = () => {
    const queryParams = new URLSearchParams({
        ...form.data(),
        bookingRequestId: props.bookingRequest.Id,
        customerId: props.customerDetails[0].id,
    }).toString();
    const URL = route('createCustomerVisit') + '?' + queryParams;
    form.get(URL,{
            preserveScroll: true
        });
}

const config = {
  enableTime: true,
  dateFormat: 'Y-m-d H:i',
  time_24hr: true
}

onMounted(() => {
    
    form.checkIn = props.bookingRequest.checkIn
    form.checkOut = props.bookingRequest.checkOut
    console.log(form.checkIn );
    console.log(form.checkOut );
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
                <div class="w-full flex items-center pl-[40%] space-x-[68%] pb-[10px]">
                    <p class="text-[18px] justify-self-center">Customer details'</p>
                    <Link class="bg-[#02703B] w-[70px] flex justify-center items-center h-[30px] rounded-[5px] text-white">Edit</Link>
                </div>
                <div class="w-full flex flex-col items-center pt-[25px]">
                    <div class="flex justify-center w-full space-x-[8%]">
                        <div class="flex flex-col w-[15%] space-y-[7px]">
                            <p>Firstname</p>
                            <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                {{ customerDetails[0].firstName }}
                            </div>
                        </div>
                        <div class="flex flex-col w-[15%] space-y-[7px]">
                            <p>Surname</p>
                            <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                {{ customerDetails[0].surname }}
                            </div>
                        </div>
                        <div class="flex flex-col w-[20%] space-y-[7px]">
                            <p>Email</p>
                            <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                {{ customerDetails[0].email }}
                            </div>
                        </div>
                        <div class="flex flex-col w-[15%] space-y-[7px]">
                            <p>username</p>
                            <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                {{ customerDetails[0].username }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-[100%] mt-[30px] flex flex-col items-center pt-[30px]">
                    <div class="w-full flex flex-col items-center pt-[25px]">
                        <form  class="w-full" @submit.prevent ="submit">
                            <div class="flex justify-center w-full space-x-[8%]">
                                <div class="flex flex-col w-[15%] space-y-[7px]">
                                    <p>Request Id</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        {{ bookingRequest.Id }}
                                    </div>
                                </div>
                                <div class="flex flex-col w-[25%] space-y-[7px]">
                                    <p>Request Created_at</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        {{ getDate(bookingRequest.created_at) }}
                                    </div>
                                </div>
                                <div class="flex flex-col w-[20%] space-y-[7px]">
                                    <p>For room Type</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        {{ getRoomType(bookingRequest.roomType) }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center w-full space-x-[8%] pt-[20px]">
                                <div class="flex flex-col w-[15%] space-y-[7px]">
                                    <p>Select Room</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        <select name="" id="" v-model="form.roomId">
                                            <div v-for="room in vacantRooms" :key="room.id">
                                                <option :value="room.id">{{ room.id }} : {{ getRoomType( room.type ) }}</option>
                                            </div>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex flex-col w-[20%] space-y-[7px]">
                                    <p>CheckIn</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        <flat-pickr v-model="form.checkIn" :config="config" :placeholder="bookingRequest.checkIn"/>
                                    </div>
                                </div>
                                <div class="flex flex-col w-[20%] space-y-[7px]">
                                    <p>Checkout</p>
                                    <div class="border-2 border-hBackground rounded-[5%] flex justify-center items-center h-[40px]">
                                        <flat-pickr v-model="form.checkOut":config="config" :placeholder="bookingRequest.checkOut"/>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center w-full space-x-[8%] pt-[20px]">
                                <div class="flex flex-col w-[10%] space-y-[7px]">
                                    <button class="border-2 bg-greenColor text-white rounded-[5%] flex justify-center items-center h-[40px]"  :disabled="form.processing">
                                        Submit
                                    </button>
                                </div>
                                <div class="flex flex-col w-[10%] space-y-[7px]">
                                    <Link :href="`/denyBookingRequest/${bookingRequest.Id}`" class="border-2 bg-redColor text-white rounded-[5%] flex justify-center items-center h-[40px]"  :disabled="form.processing">
                                        Deny
                                    </Link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </dashboardHeader>
</template>