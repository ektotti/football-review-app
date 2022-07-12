<template>
    <div class="modal-base row justify-content-center" v-if="showModal">
        <div class="modal-overlay text-center"></div>
        <component
            :is="modalContent"
            :args="args"
            @contentBtnClick="contentBtnClick"
        ></component>
    </div>
</template>

<script>
import SetPostions from "./SetPostions";
import DeletePost from "./DeletePost";
import CreatePostInfo from "./CreatePostInfo";
import RelationShipList from "./RelationShipList";
export default {
    props: {
        showModal: {
            required: true,
            type: Boolean,
        },
        modalContent: '',
        args:[]
    },
    methods: {
        contentBtnClick: function (...args) {
            this.$emit(
                "contentBtnClick",
                args[0],
            );
        },
    },
    components: {
        DeletePost,
        SetPostions,
        CreatePostInfo,
        RelationShipList
    },
};
</script>
