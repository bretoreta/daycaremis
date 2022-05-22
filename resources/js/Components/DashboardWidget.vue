<template>
    <div class="flex space-x-1 py-10">
        <div class="hover:shadow-2xl shadow-lg hover:cursor-default duration-200 rounded text-white px-20 py-5 relative overflow-x-hidden" :class="containerClasses">
            <div class="px-5 py-2 text-2xl font-bold" :class="textClasses">{{ count }}</div>
            <p class="text-lg font-bold uppercase">{{ name }}</p>
            <div v-if="icon == 'admins'" class="absolute -left-10 top-3 hover:-left-6 duration-200">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="lock-closed" class="w-24 h-24" :class="textClasses"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <div v-if="icon == 'parents'" class="absolute -left-10 top-3 hover:-left-6 duration-200">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="user-group" class="w-24 h-24" :class="textClasses"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div v-if="icon == 'staff'" class="absolute -left-10 top-3 hover:-left-6 duration-200">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="identification" class="w-24 h-24" :class="textClasses"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
            </div>
            <div v-if="icon == 'children'" class="absolute -left-10 top-3 hover:-left-6 duration-200">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="emoji-happy" class="w-24 h-24" :class="textClasses"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div v-if="icon == 'meals'" class="absolute -left-10 top-3 hover:-left-6 duration-200">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="cake" class="w-24 h-24" :class="textClasses"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
            </div>
        </div>     
    </div>
</template>
<script>
import { defineComponent, ref } from 'vue'

export default defineComponent({
    props: {
        containerClasses: String,
        textClasses: String,
        icon: String,
        name: String,
        count: String,
    },
})
</script>
<style>
    
</style>