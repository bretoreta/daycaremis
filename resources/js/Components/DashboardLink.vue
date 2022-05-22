<template>
    <div class="pt-3">
        <Link :href="href" :class="classes">
            <slot></slot>
        </Link>
    </div>
</template>
<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: {
            href : String,
            active : Boolean
        },
        computed: {
            classes() {
                return this.active ? "uppercase font-bold tracking-wider text-white"
                                    : "uppercase tracking-wider text-gray-400 hover:text-gray-600 duration-200 focus:text-gray-600"
            }
        }    
    })
</script>
<style>
    
</style>