<script setup>
import Menu from '../Components/Menu.vue';
const props = defineProps({
    content : String,
})
</script>
<template>
    <Head>
        <meta head-key="Dashboard" name="Dashboard" content="Dashboard"/>
    </Head>
    <div class="w-full h-[70px] bg-hBackground flex pr-[2%] items-center pl-[3%] space-x-[80%]">
        <div class="">
            <img src="/public/images/LogoSquare.png" alt="Logo" class="w-[80px] h-[60px] rounded-[15px]">
        </div>
        <div class="w-[15%] flex justify-between items-center">
            <Link :href="route('bookingRequests')"><img src="/public/images/Notifications.png" alt="notifications" class="w-[45px] h-[41px]"></Link>
            <Link :href="route('editAdminProfile')"><img src="/public/images/setting.png" alt="setting" class="w-[40px] h-[38px]"></Link>
            <img src="/public/images/Profile.png" alt="profile" class="w-[45px] h-[38px]">
        </div>   
    </div>
    <div class="flex">
        <slot name = "sideBar">
            <div class="flex flex-col border-r-[3px] border-hBackground w-[15%] h-[650px] bg-white pt-[15px] gap-y-[10px] relative">
                <Menu :content="content" buttonName="Rooms" link1="All rooms" link2="Booked rooms" link3="Vacant rooms" routeName1="allRooms" routeName2="bookedRooms" routeName3="vacantRooms" img="Rooms.png" imageWidth="23" imageHeight="27"></Menu> 
                <Menu :content="content" linkName="Customers" routeName1="allCustomers" img="Customers.png" imageWidth="27" imageHeight="27"></Menu>
                <Menu linkName="Booking requests" routeName1="bookingRequests" img="Messages.png" imageWidth="25" imageHeight="25"></Menu>
                <Link :href="route('logout')" class="text-black flex ml-[10%] absolute bottom-[40px] gap-x-[5%] w-[90%] items-center">
                    <img src="/public/images/logOut.svg" alt="Log Out" width="30px" height="30px" class="bg-">
                    Log out
                </Link>
            </div>
        </slot>
        <slot name = "main">
            
        </slot>
    </div> 
</template>