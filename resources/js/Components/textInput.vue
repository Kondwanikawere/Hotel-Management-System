<script setup>
    const model = defineModel({
        type : null,
        Required : true
    })

    defineProps({
        name : {
            type : String,
            required : true
        },
        type : {
            type : String,
            default : "text"
        },
        message : String,
        placeholder : {
            type : String,
            required : true
        },
        label : String,
    })
</script>
<template>
    <div class="w-[100%]">
        <label for="inputText" class="text-[16px] ml-[1%]">{{label}}</label>
        <input name="inputText" v-model="model" :type="type" :id="name" class="text-[16px] autofill:border-2 autofill:border-[#02984a88] autofill:shadow-[inset_0_0_0px_1000px_rgb(0,17,32)] text-white w-[100%] bg-white bg-opacity-0 focus:text-white hover:bg-background border-2 border-White h-[45px] rounded-[10px] pl-[10%] mt-[5px]" :class="{'!border-textRed' : message}"  :placeholder="placeholder" required>
        <p class="text-[12px] pt-2 pl-4 text-textRed" v-if="message">{{ message }}</p>
    </div>
</template>