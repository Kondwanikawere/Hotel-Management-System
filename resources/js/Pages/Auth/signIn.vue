<script setup>
import textInput  from '../../Components/textInput.vue';
import {useForm} from '@inertiajs/vue3'

const form = useForm({
    email : null,
    password : null,
    remember : null,
})

const submit = () => {
    form.post(route('login'),{
        preserveScroll: true,
        onError : () => form.reset('password')
    })
}
</script>
<template>
    <Head>
        <title> | Sign In </title>
        <meta head-key="description" name="description" content="The register page"/>
    </Head>
    <div class="flex bg-[#161433] w-[40%] h-[570px] text-white justify-self-center mt-[62px] rounded-[10px] justify-center">
        <div class="w-[60%] flex flex-col justify-start mt-[120px]">
            <div class="flex justify-center w-[100%]">
                <p class="text-[24px]">The Royal Haven Hotel</p>
            </div>
            
            <div class="flex justify-center">
                <form @submit.prevent ="submit" class="flex flex-col items-center text-white w-[90%] text-[20px] pl-[2%] pt-[47px] gap-y-[0.5rem]">
                    <textInput label="Email" name="email" v-model="form.email" placeholder="email" type="email" :message="form.errors.email"></textInput>
                    <textInput label="Password" name="password" v-model="form.password" placeholder="Password" type="password" :message="form.errors.password"></textInput>
                    <div class="flex w-[30%]">
                        <button id="submit" class="bg-white text-black text-[18px] h-[35px] rounded-[10px] w-[100%] disabled:opacity-60" :disabled="form.processing"><p>Sign in</p></button>
                    </div>
                </form>
            </div>

            <div class="flex justify-center gap-x-1 mt-[5px] text-[10px]">
                    <p>Don't have an account?</p>
                    <a :href="route('register')" class="text-textRed"> Sign up now</a>
            </div>
        </div>
    </div>
</template>