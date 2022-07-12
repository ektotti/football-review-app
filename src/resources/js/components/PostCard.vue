<template>
    <div class="col-md-8 mx-auto">
        <div
            class="card mb-5"
            id="post-card"
            v-for="(post, index) in posts"
            :key="index"
        >
            <CardHeader :post="post"></CardHeader>
            <CardBody
                :post="post"
                :isIndex="isIndex"
                :likeThisPost="likeThisPost"
                :isSelf="isSelf"
            ></CardBody>
            <CardFooter :post="post" v-show="!isIndex"></CardFooter>
        </div>
        <infinitLoading
            @infinite="infiniteHandler"
            v-if="isIndex"
        ></infinitLoading>
    </div>
</template>

<script>
import Axios from "axios";
import infinitLoading from "vue-infinite-loading";

export default {
    props: {
        initPost: {
            require: false,
            default: () => ({}),
        },
        isIndex: {
            type: Boolean,
            default: false,
        },
        likeThisPost: {
            type: Boolean,
        },
        isSelf: {
            type: Boolean,
        },
        tagName: {
            type: String,
            required: false,
            default: "",
        },
        errors: {
            requred: false,
        },
    },
    data: function () {
        return {
            posts: [],
            page: 1,
        };
    },
    methods: {
        infiniteHandler: async function ($state) {
            let url = this.tagName
                ? `/api/post/${this.tagName}?page=${this.page}`
                : `/api/post?page=${this.page}`;
            let response = await Axios.get(url);
            console.log(response);
            for (let PostObj of response.data.data) {
                PostObj.images = this.getImageName(PostObj);
                this.posts.push(PostObj);
            }
            $state.loaded();
            this.page += 1;
        },
        getImageName: function ({ image1, image2, image3, image4 }) {
            let images = [image1, image2, image3, image4];
            let imagename = images.filter(function (value) {
                return value != null;
            }, images);
            return imagename;
        },
    },
    mounted: function () {
        if (this.errors) {
            for (let key in this.errors) {
                alert(this.errors[key]);
            }
        }
        if (!this.isIndex) {
            this.initPost.images = this.getImageName(this.initPost);
            this.posts.push(this.initPost);
        }
        console.log(this.errors);
    },
    components: {
        infinitLoading,
    },
};
</script>
