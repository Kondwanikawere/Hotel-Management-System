<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  content : String,
  buttonName: {
    type: String,
    default: null,
  },
  linkName: {
    type: String,
    default: null,
  },
  link1: {
    type: String,
    default: null,
  },
  link2: {
    type: String,
    default: null,
  },
  link3: {
    type: String,
    default: null,
  },
  routeName1: {
    type: String,
    default: null,
  },
  routeName2: {
    type: String,
    default: null,
  },
  routeName3: {
    type: String,
    default: null,
  },
  img : {
    type: String,
    default: null,
  },
  imageWidth : {
    type: String,
    default: null,
  },
  imageHeight : {
    type: String,
    default: null,
  }
});

const isOpen = ref(false); // Controls dropdown visibility

// Toggle dropdown visibility
const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

// Close dropdown
const closeDropdown = () => {
  isOpen.value = false;
};

onMounted(() => {
  if(props.content === props.routeName1 || props.content === props.routeName2 || props.content === props.routeName3){
    isOpen.value = true;
  }
})

</script>

<template>
  <div class="w-full relative">
    <!-- Dropdown Button -->
    
    <div class="flex justify-center">
      <button
        @click="toggleDropdown"
        class="flex space-x-[8%] items-center pl-[10%] text-black text-[14px] bg-hBackground w-[90%] h-[40px] rounded-[10px]"
      >
        <img :src="`/images/${img}`" :alt="img" :class="`w-[${imageWidth}px] h-[${imageHeight}px]`">
        <p v-if="buttonName !== null">{{ buttonName }}</p>
        <Link :href="route(routeName1)" v-if="linkName !== null">
          {{ linkName }}
        </Link>
      </button>
    </div>

    <!-- Dropdown Menu -->
    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div v-if="isOpen && (link1 !== null && link2 !== null)" class="flex flex-col divide-y-2 text-[13px] border-2 border-hBackground w-[80%] ml-[15%] mt-[5px] rounded-[5px] text-black bg-white">
        <Link :href="route(routeName1)" v-if="link1 !== null" :class="{'bg-[#A2A2A2]' : content === routeName1}" class="pl-[7%] h-[35px] flex items-center justify-center]" tabindex="0">
            {{ link1 }}
        </Link>
        <Link :href="route(routeName2)" v-if="link2 !== null" :class="{'bg-[#A2A2A2]' : content === routeName2}" class="pl-[7%] h-[35px] flex items-center justify-center]" tabindex="0">
            {{ link2 }}
        </Link>
        <Link :href="route(routeName3)" v-if="link3 !== null"  :class="{'bg-[#A2A2A2]' : content === routeName3}" class="pl-[7%] h-[35px] flex items-center justify-center]" tabindex="0">
            {{ link3 }}
        </Link>
      </div>
    </transition>
  </div>
</template>