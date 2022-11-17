<template>
    <div class="col-md-8 mx-auto">
        <div
            class="card mb-5"
            id="post-card"
            v-for="(post, index) in posts"
            :key="index"
        >
            <PostCardHeader :post="post"></PostCardHeader>
            <PostCardBody
                :post="post"
                :isIndex="isIndex"
                :likeThisPost="initPost.likeThisPost"
                :isSelf="initPost.isSelf"
            ></PostCardBody>
            <PostCardFooter :post="post" v-show="!isIndex"></PostCardFooter>
        </div>
        <infinitLoading
            @infinite="infiniteHandler"
            v-if="isIndex"
        ></infinitLoading>
    </div>
</template>

<script>
import PostCardHeader from "./PostCardHeader.vue";
import PostCardBody from "./PostCardBody.vue";
import PostCardFooter from "./PostCardFooter.vue";
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
            hasMorePage: true,
        };
    },
    methods: {
        infiniteHandler: async function ($state) {
            if (this.hasMorePage) {
                let url = this.tagName
                    ? `/post-list/${this.tagName}?page=${this.page}`
                    : `/post-list?page=${this.page}`;
                let response = await Axios.get(url);

                if (response.data.errorMessage) {
                    alert(response.data.errorMessage);
                    $state.complete();
                }

                for (let PostObj of response.data.data) {;
                    this.posts.push(PostObj);
                }

                $state.loaded();
                this.hasMorePage = response.data.links.next ? true : false;
                this.page += 1;
            } else {
                $state.complete();
            }
        },
    },
    mounted: function () {
        if (this.errors) {
            for (let key in this.errors) {
                alert(this.errors[key]);
            }
        }
        if (!this.isIndex) {
            console.log(this.initPost);
            this.posts.push(this.initPost);
        }
    },
    components: {
        infinitLoading,
        PostCardHeader,
        PostCardBody,
        PostCardFooter,
    },
};
</script>
