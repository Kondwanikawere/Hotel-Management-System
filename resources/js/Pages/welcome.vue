<script setup>
const myDetails = '/myDetails'
const rooms = '/rooms'
    
</script>
<template>
    <Head>
        <title> | Welcome</title>
        <meta head-key="Welcome" name="Welcome" content="Welcome"/>
    </Head>
    <div class="w-full flex flex-col h-[820px] items-center mt-[60px]">
            <img src="/public/images/Hotel Logo.png" alt="logo" class="w-[140px] h-[140px] rounded-full object-cover">
            <p class="pt-[37px] text-[24px]">Welcome To The Grand Opulence Hotel</p>
            <p class="pt-[5px] text-[16px]">Experience the perfect blend of Luxury and Comfort</p>
            <Link v-if="!$page.props.auth.user" :href="route('login')"  class="w-[6%] h-[35px] bg-white text-black text-[14px] flex justify-center rounded-[10px] items-center mt-[27px]">Book now</Link>
            <div v-if="$page.props.auth.user" class="w-[6%]">
                <a v-if="$page.props.auth.user.role === 0" :href="rooms" class="w-[100%] h-[35px] bg-white text-black text-[14px] flex justify-center rounded-[10px] items-center mt-[27px]">Book now</a>
                <a v-if="$page.props.auth.user.role === 1" :href="myDetails" class="w-[100%] h-[35px] bg-white text-black text-[14px] flex justify-center rounded-[10px] items-center mt-[27px]">Book now</a>
            </div>
            <p class="text-[18px] mt-[30px]">Featured Rooms</p>
            <div class="w-full h-[400px] bg-[#161433] mt-[10px] flex justify-around items-center">
                <img src="/public/images/Hotel1.jpg" alt="hotel1" class="w-[45%] h-[350px] rounded-[10px]">
                <img src="/public/images/hotel2.jpg" alt="hotel2" class="w-[45%] h-[350px] rounded-[10px]">
            </div>
    </div>
</template>