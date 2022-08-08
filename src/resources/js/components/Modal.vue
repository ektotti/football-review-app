<template>
    <transition name="fade">
        <div class="modal-base row justify-content-center" v-if="showModal">
            <div class="modal-overlay text-center"></div>
            <slot></slot>
        </div>
    </transition>
</template>

<script>
import ModalContentSetPostions from "./ModalContentSetPostions";
import ModalContentPostDelete from "./ModalContentPostDelete.vue";
import ModalContentPostCreationInfo from "./ModalContentPostCreationInfo.vue";
import ModalContentRelationShipList from "./ModalContentRelationShipList.vue";
export default {
    props: {
        showModal: "",
    },
    components: {
        ModalContentSetPostions,
        ModalContentPostDelete,
        ModalContentPostCreationInfo,
        ModalContentRelationShipList,
    },
    mounted: function (){
        console.log(this.showModal);
    }
};
</script>
