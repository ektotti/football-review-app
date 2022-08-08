<template>
    <div class="rounded-lg p-5 modal-content col-3" id="deleteconfirm">
        <p class="text-center">本当に削除しますか？？</p>
        <div class="row col-12 justify-content-between mx-auto">
            <button class="btn btn-secondary btn-sm" @click="contentBtnClick">
                戻る
            </button>
            <div class="">
                <form :action="`/post/${args.postId}`" method="post">
                    <input type="hidden" name="_token" :value="csrf" />
                <input type="hidden" name="_token" :value="csrf" />
                    <input type="hidden" name="_method" value="DELETE" />
                    <input
                        class="btn btn-danger btn-sm"
                        type="submit"
                        value="削除"
                    />
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        args:[],
    },
    data:function() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    methods: {
        contentBtnClick: function () {
            this.$emit("contentBtnClick");
        },
    },
    mounted: function() {
        console.log('content',this.args.postId);
    }
};
</script>
