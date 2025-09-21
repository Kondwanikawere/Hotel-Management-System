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
    <div class="bg-navBar font-[Poppins] w-full h-[60px]  flex pr-[2%] items-center pl-[3%] space-x-[80%]">
        <div class="">
            <img src="/public/images/LogoSquare.png" alt="Logo" class="w-[60px] h-[50px] rounded-[5px]">
        </div>
        <div class="w-[15%] flex justify-between items-center">
            <Link :href="route('bookingRequests')"><img src="/public/images/Notifications.png" alt="notifications" class="w-[28px] h-[28px]"></Link>
            <Link :href="route('editAdminProfile')"><img src="/public/images/setting.png" alt="setting" class="w-[30px] h-[30px]"></Link>
            <img src="/public/images/Profile.png" alt="profile" class="w-[35px] h-[35px] rounded-[100%]">
        </div>   
    </div>
    <div class="font-[Poppins] flex">
        <slot name = "sideBar">
            <div class="flex flex-col border-r-[3px] bg-sideBar border-hBackground w-[15%] h-[650px] pt-[15px] gap-y-[10px] relative">
                <Menu :content="content" buttonName="Rooms" link1="All rooms" link2="Booked rooms" link3="Vacant rooms" routeName1="allRooms" routeName2="bookedRooms" routeName3="vacantRooms" img="Rooms.png" imageWidth="25" imageHeight="25"></Menu> 
                <Menu :content="content" linkName="Customers" routeName1="allCustomers" img="People.png" imageWidth="30" imageHeight="25"></Menu>
                <Menu linkName="Booking requests" routeName1="bookingRequests" img="Messages.png" imageWidth="22" imageHeight="22"></Menu>
                <Menu linkName="Staff" routeName1="bookingRequests" img="People.png" imageWidth="30" imageHeight="25"></Menu>
                <Menu linkName="Inventory" routeName1="bookingRequests" img="Inventory.png" imageWidth="21" imageHeight="21"></Menu>
                <Menu linkName="Menu" routeName1="bookingRequests" img="Menu.png" imageWidth="30" imageHeight="30"></Menu>
                <Menu linkName="Accounts" routeName1="bookingRequests" img="Accounts.png" imageWidth="21" imageHeight="21"></Menu>
                <Menu linkName="Reports" routeName1="bookingRequests" img="Reports.png" imageWidth="25" imageHeight="25"></Menu>
                <Menu linkName="Map" routeName1="bookingRequests" img="Map.png" imageWidth="27" imageHeight="27"></Menu>
                <Link :href="route('logout')" class="text-white flex ml-[10%] absolute bottom-[40px] gap-x-[5%] w-[90%] items-center">
                    <img src="/public/images/logOut.svg" alt="Log Out" width="30px" height="30px" class="bg-">
                    Log out
                </Link>
            </div>
        </slot>
        <slot name = "main">
            
        </slot>
    </div> 
</template>