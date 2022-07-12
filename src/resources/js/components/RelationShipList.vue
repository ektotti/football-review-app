<template>
    <div class="col-3 modal-content card">
        <div class="card-header row justify-content-end align-items-center">
            <h3 class="col-auto mb-0">follow</h3>
            <i
                class="col-2 offset-2 fa-regular fa-circle-xmark fa-lg"
                @click="click"
            ></i>
        </div>
        <ul
            class="list-group list-group-flush"
            v-for="(follow, index) in relationList"
            :key="index"
        >
            <li class="list-group-item text-center" v-if="hasRelation">
                <span class="card-text col-3 text-center">{{
                    follow.name
                }}</span>
            </li>
        </ul>
        <p v-if="!hasRelation" class="text-center py-5">
            フォローしているユーザーはいません。
        </p>
    </div>
</template>
<script>
export default {
    props: {
        args: [],
    },
    data: function () {
        return {
            relationList: [],
            hasRelation: "",
        };
    },
    methods: {
        click: function (event) {
            this.$emit("contentBtnClick");
        },
    },
    mounted: function () {
        console.log('modal content',this.args.relationList);
        if (this.args.relationList) {
            this.hasRelation = false;
        } else {
            this.hasRelation = true;
            this.relationList = this.args.relationList;
        }
        console.log('判定', this.hasRelation);
    },
};
</script>
