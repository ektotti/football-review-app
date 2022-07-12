<template>
    <carousel :perPage="1" :navigationEnabled="isIndex" :paginationEnabled="!isIndex">
        <slide v-for="(image, index) in images" :key="index">
            <a :href="'/post/' + postId" v-if="isIndex">
                <img :src="image" alt="" class="col-12 px-0" />
            </a>
            <img :src="image" alt="" class="col-12 px-0" v-if="!isIndex" />
        </slide>
    </carousel>
</template>
<script>
import { Carousel, Slide } from "vue-carousel";
export default {
    props: {
        images: [],
        isIndex: "",
        postId: "",
        isCreate: "",
    },
    data: function () {
        return {
            imagesPath: '',
        };
    },
    mounted: function () {
        if (this.isCreate) {
            this.imagesPath = ''; 
        } else {
            this.imagesPath = '/storage/'
        }
    },
    components: {
        Carousel,
        Slide,
    },
};
</script>
