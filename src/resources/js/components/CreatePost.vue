<template>
    <div class="main-content-warapper">
        <div class="main-content-inner">
            <div class="row">
                <div class="slide col-8 px-0">
                    <post-image-carousel
                        :images="images"
                        :width="600"
                        :isIndex="false"
                        :isCreate="true"
                    >
                    </post-image-carousel>
                </div>
                <div
                    class="textcontent col-4 d-flex flex-column justify-content-between"
                >
                    <input
                        type="text"
                        class="border-0 mb-2 py-2 rounded-lg"
                        style="height: 10%"
                        placeholder="レビューにタイトルを付けましょう！"
                        v-model="title"
                    />
                    <div style="height: 80%" class="px-0 col-auto">
                        <textarea
                            class="col-12 border-0 rounded-lg"
                            placeholder="レビューを書きましょう！"
                            v-model="textContent"
                        ></textarea>
                    </div>
                    <div
                        class="mt-3 d-flex justify-content-end"
                        style="height: 10%"
                    >
                        <div class="">
                            <label for="file_upload" class="mb-0"
                                >デバイスから選ぶ</label
                            ><input
                                type="file"
                                name="file"
                                id="file_upload"
                                accept="image/*"
                                multiple="multiple"
                                class="d-none"
                                @change="upLoadImages"
                            /><button
                                class="btn btn-primary ml-2"
                                @click="sendForm"
                            >
                                投稿する
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <portal to="modal">
            <Modal :showModal="showModal">
                <ModalContentPostCreationInfo></ModalContentPostCreationInfo>
            </Modal>
        </portal>
    </div>
</template>
<script>
import PortalVue from "portal-vue";
Vue.use(PortalVue);
import PostImageCarousel from "./PostImageCarousel.vue";
import Modal from "./Modal.vue";
import axios from "axios";
import ModalContentPostCreationInfo from "./ModalContentPostCreationInfo.vue";

export default {
    props: {
        csrf: {
            type: String,
            require: true,
        },
    },
    data: function () {
        return {
            images: [],
            textContent: "",
            title: "",
            showModal: false,
        };
    },
    methods: {
        sendForm: async function () {
            try {
                axios.interceptors.request.use((request) => {
                    console.log("Starting Request: ", request);
                    return request;
                });
                let response = await axios.post("/post", {
                    textContent: this.textContent,
                    title: this.title,
                    images: this.images,
                });
                if (response.status == 200) {
                    this.showModal = true;
                    this.removeImagesFromSession();
                }
            } catch (error) {
                let errors;
                errors =
                    error.response.status === 422
                        ? error.response.data.errors
                        : error.response.data.message;
                console.log(error.response);
                if (typeof errors === "object") {
                    for (let key in errors) {
                        alert(errors[key][0]);
                    }
                } else {
                    alert(errors);
                }
            }
        },
        upLoadImages: function (e) {
            let fileList = e.target.files;
            let imagesFromSession = JSON.parse(
                sessionStorage.getItem("images")
            );
            if (imagesFromSession.length + fileList.length > 4) {
                alert("1度に投稿できる画像は4枚までです。");
                return;
            }
            for (let key in e.target.files) {
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[key]);
                reader.onload = function (e) {
                    this.images.push(e.target.result);
                }.bind(this);
            }
        },
        setImagesFromSession: function () {
            if (JSON.parse(sessionStorage.getItem("images"))) {
                this.images = JSON.parse(sessionStorage.getItem("images"));
            } else {
                return;
            }
        },
        removeImagesFromSession: function () {
            if (sessionStorage.getItem("images")) {
                sessionStorage.removeItem("images");
            } else {
                return;
            }
        },
    },
    mounted: function () {
        this.setImagesFromSession();
        if (this.images.length >= 4) {
            this.$el.querySelector("#file_upload").setAttribute("disabled");
        }
    },
    components: {
        PostImageCarousel,
        Modal,
        ModalContentPostCreationInfo,
    },
};
</script>
