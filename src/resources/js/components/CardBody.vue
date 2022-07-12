<template>
    <div class="card-body pb-0">
        <div class="card-body-image">
            <post-image-carousel
                class="VueCarousel col-12 px-0"
                :images="post.images"
                :postId="post.id"
                :isIndex="isIndex"
            >
            </post-image-carousel>
        </div>
        <div class="card-body row mt-2 align-items-center py-2" v-if="isIndex">
            <i class="fa-solid fa-heart fa-lg mr-1"></i>
            <span class="mr-4">{{ post.likes.length }}</span>
            <i class="fa-regular fa-comment fa-lg mr-1"></i>
            <span>{{ post.comments.length }}</span>
        </div>
        <div class="card-body row mb-2 align-items-center py-2" v-if="!isIndex">
            <a
                class="text-body"
                :href="`/unlike/${post.id}`"
                v-if="likeThisPost"
            >
                <i class="fa-solid fa-heart fa-lg mr-1"></i>
            </a>
            <a
                class="text-body"
                :href="`/like/${post.id}`"
                v-if="!likeThisPost"
            >
                <i class="fa-regular fa-heart fa-lg mr-1"></i>
            </a>
            <span class="mr-3">{{ post.likes.length }}</span>
            <i class="fa-regular fa-comment fa-lg mr-1"></i>
            <span class="mr-3">{{ post.comments.length }}</span>
            <span class="text-body" href="" v-if="isSelf">
                <i
                    class="fa-solid fa-pen-to-square fa-lg mr-2"
                    @click="modifyMode = !modifyMode"
                ></i>
            </span>
            <button class="btn" v-if="isSelf">
                <i
                    class="fa-solid fa-trash fa-lg mr-1"
                    @click="showModal = true"
                ></i>
            </button>
        </div>
        <div class="card-body-text" v-if="!isIndex">
            <span v-if="!modifyMode">{{ post.body }}</span>
            <div
                class="d-flex col-12 px-0 py-3 align-self-start rounded-lg"
                v-if="modifyMode"
                id="edit-post-form"
            >
                <div class="d-flex flex-column col-11 rounded-ls p-4">
                    <input
                        class="d-block mb-3 border-0 rounded-lg"
                        type="text"
                        name="title"
                        placeholder="タイトルを付けましょう！"
                        v-model="post.title"
                    />
                    <textarea
                        class="border-0 form-control"
                        name="body"
                        id="floatingTextarea"
                        cols="10"
                        rows="5"
                        v-model="post.body"
                        autofocus
                    >
 {{ post.body }} </textarea
                    >
                </div>
                <button class="btn px-0 mx-auto" @click="modifyPost">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
        <button
            class="btn py-0 mt-4 mb-2 px-0"
            @click="showComment = !showComment"
            v-if="!isIndex"
        >
            コメントを見る
        </button>
        <ul class="list-unstyled my-4" v-if="!isIndex" v-show="showComment">
            <li
                class="list-unstyled my-4"
                v-for="(comment, index) in post.comments"
                :key="index"
            >
                <p class="mb-0">{{ comment.user.name }}</p>
                <span>{{ comment.body }}</span>
            </li>
        </ul>
        <portal to="modal">
            <Modal
                @contentBtnClick="showModal = false"
                :showModal="showModal"
                :modalContent="'DeletePost'"
                :args="{ postId: post.id }"
                v-if="!isIndex"
            >
            </Modal>
        </portal>
    </div>
</template>
<script>
import Modal from "./Modal.vue";
import PortalVue from "portal-vue";
import Axios from "axios";
Vue.use(PortalVue);
export default {
    props: {
        post: {},
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
    },
    data: function () {
        return {
            showComment: false,
            showModal: false,
            modifyMode: false,
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            modifiedTitle: '',
            modifiedBody: '',
        };
    },
    methods: {
        modifyPost: async function () {
            try {
                let response = await Axios.put(`/post/${this.post.id}`, {
                    userId: this.post.user_id,
                    title: this.post.title,
                    body: this.post.body,
                });
                if(response.status === 200) {
                    alert('投稿が修正出来ました。');
                }
            } catch (error) {
                console.log(error.response);
                alert('なんかおかしいです。');
            }

        },
    },
    components: {
        Modal,
    },
};
</script>
