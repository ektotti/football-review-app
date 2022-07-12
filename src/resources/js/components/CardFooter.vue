<template>
    <div class="card-footer">
        <div class="d-flex col-12 px-0 align-self-start">
            <input type="hidden" name="postUserId" :value="post.user.id" />
            <input type="hidden" name="postId" :value="post.id" />
            <textarea
                class="col-11 border-0 form-control"
                v-model="body"
                id="floatingTextarea"
                cols="10"
                rows="2"
                placeholder="コメントをする"
            ></textarea>
            <button class="btn px-0 mx-auto" @click="createComment">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</template>
<script>
import Axios from "axios";

export default {
    props: {
        post: {},
        isIndex: {
            type: Boolean,
            default: false,
        },
    },
    data: function () {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            body: "",
        };
    },
    methods: {
        createComment: async function () {
            try {
                let response = await Axios.post("/comment", {
                    postUserId: this.post.user.id,
                    postId: this.post.id,
                    body: this.body,
                });
                if (response.status === 200) {
                    location.reload();
                    alert("コメント出来ました。");
                }
            } catch (error) {
                console.log(error.response);
                alert("なんかおかしいです。");
            }
        },
    },
};
</script>
