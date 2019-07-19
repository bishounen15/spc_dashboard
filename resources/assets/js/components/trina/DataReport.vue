<template>
    <div>
        <h3 class="mb-4"><i v-bind:class="icon"></i> {{title}}</h3>
    </div>
</template>

<script>
    export default {
        mounted() {

        },
        data() {
            return {

            }
        },
        created() {
            
        },
        props: {
            title: String,
            icon: String
        },
        methods: {

        }
    }
</script>