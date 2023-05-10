<template>
    <div>
        <!--HTML-->
        <v-card v-for="i in 3" :key="i" height="220" class="my-4">
            <div class="display-1 text-center px-2 my-auto">
                <p class="my-0" style="line-height: 220px;">БАННЕР {{i+1}}</p>
            </div>
        </v-card>
    </div>
</template>

<!--CSS-->
<style>

</style>

<script> 

export default {
    name: 'banners',
    data () {
        return {
        }
    },
    mounted() {
    },
    methods: {
    },
    props: {
    },
    components: {
    },
    computed: {
    },
};
</script>

