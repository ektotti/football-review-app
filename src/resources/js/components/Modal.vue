<template>
    <div class="modal-base row justify-content-center">
        <div class="modal-overlay text-center"></div>
        <slot></slot>
    </div>
</template>

<script>
import SetPostions from "./SetPostions";
import DeletePost from "./DeletePost";
import CreatePostInfo from "./CreatePostInfo";
import RelationShipList from "./RelationShipList.vue";
export default {
    components: {
        DeletePost,
        SetPostions,
        CreatePostInfo,
        RelationShipList
    },
};
</script>
