<template>
    <div class="mb-5">
        <carousel-3d :autoplay="true" :autoplay-timeout="3000">
            <slide :index="0">
                <img src="/images/4.jpg" width="100%" height="100%">
            </slide>
            <slide :index="1">
                <img src="/images/5.jpg" width="100%" height="100%">
            </slide>
            <slide :index="2">
                <img src="/images/22.jpg" width="100%" height="100%">
            </slide>
            <slide :index="3">
                <img src="/images/6.jpg" width="100%" height="100%">
            </slide>
            <slide :index="4">
                <img src="/images/2.jpg" width="100%" height="100%">
            </slide>
        </carousel-3d>



    </div>
</template>

<script>
    import {Carousel3d, Slide} from 'vue-carousel-3d';


    export default {
        name: "HomeSliderComponent",

        components:{
            Carousel3d,
            Slide
        }
    }
</script>

<style scoped>

</style>