<script setup>
import dashboardHeader from '../../Layouts/dashboardHeader.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';

</script>
<template>
    <Head>
        <title> | Dashboard</title>
        <meta head-key="Dashboard" name="Dashboard" content="Dashboard"/>
    </Head>
    <dashboardHeader :content="content">
        <template #main>
           
        </template>
    </dashboardHeader>
    
</template>