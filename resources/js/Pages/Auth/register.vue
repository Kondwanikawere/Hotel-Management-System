<script setup>
   
    import {useForm} from '@inertiajs/vue3'
    import textInput  from '../../Components/textInput.vue';

    const form = useForm({
        firstName : null,
        surname : null,
        username : null,
        email : null,
        password : null,
        password_confirmation : null,
    })

    const submit = () => {
        form.post(route('register'),{
            preserveScroll: true,
            onError : () => form.reset('password','password_confirmation')
        })
    }
</script>
<template>
    <Head>
        <title> | Register </title>
        <meta head-key="description" name="description" content="The register page"/>
    </Head>
    <div class="flex bg-[#161433] w-[40%] h-[730px] text-white justify-self-center mt-[5px] rounded-[10px] justify-center">
        <div class="w-[60%] flex flex-col justify-start mt-[5px]">
            <div class="flex justify-center w-[100%]">
                <p class="text-[24px]">The Grand Opulence Hotel</p>
            </div>
            
            <div class="flex justify-center">
                <form @submit.prevent ="submit" class="flex flex-col items-center text-white w-[90%] text-[20px] pl-[2%] pt-[10px] gap-y-[1rem]">
                    <textInput label="Firstname" name="firstName" v-model="form.firstName" placeholder="FirstName" type="text" :message="form.errors.firstName"></textInput>
                    <textInput label="Surname" name="surname" v-model="form.surname" placeholder="surname" type="text" :message="form.errors.surname"></textInput>
                    <textInput label="Username" name="username" v-model="form.username" placeholder="username" type="text" :message="form.errors.username"></textInput>
                    <textInput label="Email" name="email" v-model="form.email" placeholder="email" type="email" :message="form.errors.email"></textInput>
                    <textInput label="Password" name="password" v-model="form.password" placeholder="Password" type="password" :message="form.errors.password"></textInput>
                    <textInput label="Comfirm Password" name="password_confirmation" v-model="form.password_confirmation" placeholder="Confirm password" type="password"></textInput>
                    <div class="flex w-[30%]">
                        <button id="submit" class="bg-white text-black text-[18px] h-[35px] rounded-[10px] w-[100%] disabled:opacity-60" :disabled="form.processing"><p>Sign Up</p></button>
                    </div>
                </form>
            </div>

            <div class="flex justify-center gap-x-1 mt-[5px] text-[10px]">
                    <p>Already have an account?</p>
                    <a :href="route('login')" class="text-textRed"> Sign in now</a>
            </div>
        </div>
    </div>
</template>