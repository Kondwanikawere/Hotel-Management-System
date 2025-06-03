<script setup>
import dashboardHeader from '../../Layouts/customerDashboardHeader.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';
import textInput  from '../../Components/editProfileTextInput.vue';
import { computed, ref, watch, onMounted } from "vue";
import { router, useForm } from '@inertiajs/vue3'
import { throttle } from 'lodash';
import { debounce } from 'lodash';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

const props = defineProps({
    user : Object,
})

const content = ""

const form = useForm({
        firstName : null,
        surname : null,
        username : null,
        email : null,
        password : null,
    })

    const submit = () => {
        form.get(route('updateProfile'),{
            preserveScroll: true,
            onError : () => form.reset('password','password_confirmation')
        })
    }

onMounted(() => {
    form.firstName = props.user.firstName
    form.surname = props.user.surname
    form.username = props.user.username
    form.email = props.user.email
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
                <p class="text-[18px] pb-[10px]">My profile</p>
                <div class="w-[25%] flex flex-col items-center pt-[15px]">
                        <form @submit.prevent ="submit" class="flex flex-col items-center w-[100%] text-[20px] pl-[2%] pt-[10px] gap-y-[1rem] text-black">
                            <textInput label="Firstname" name="firstName" v-model="form.firstName" :placeholder="user.firstName" type="text" :message="form.errors.firstName"></textInput>
                            <textInput label="Surname" name="surname" v-model="form.surname" :placeholder="user.surname" type="text" :message="form.errors.surname"></textInput>
                            <textInput label="Username" name="username" v-model="form.username" :placeholder="user.username" type="text" :message="form.errors.username"></textInput>
                            <textInput label="Email" name="email" v-model="form.email" :placeholder="user.email" type="email" :message="form.errors.email"></textInput>
                            <textInput label="Password" name="password" v-model="form.password" placeholder="Password" type="password" :message="form.errors.password"></textInput>
                            <div class="flex w-[30%]">
                                <button id="submit" class="bg-redColor text-white text-[18px] h-[35px] rounded-[10px] w-[100%] disabled:opacity-60" :disabled="form.processing"><p>Edit</p></button>
                            </div>
                        </form>
                </div>
            </div>
        </template>
    </dashboardHeader>
    
</template>