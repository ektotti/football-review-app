<template>
    <div class="tactical-board-buttons col-12 mt-2">
        <div class="row justify-content-between">
            <div class="col-5 row justify-content-center">
                <button
                    class="col-2 btn mr-2 btn-drawing"
                    @click="_onClickRect"
                >
                    □
                </button>
                <button class="col-3 btn btn-drawing" @click="_onClickText">
                    テキスト
                </button>
                <button
                    class="btn btn-drawing ml-2 col-3"
                    @click="_onClickLine"
                    id="line"
                >
                    実線
                </button>
                <button
                    class="btn btn-danger ml-2 col-3"
                    @click="_onClickDelete"
                    id="delete"
                    disabled
                >
                    削除
                </button>
            </div>
            <div class="col-5 row justify-content-end">
                <button class="col-0.5 btn btn-outline-secondary mr-2">
                    <a class="text-body" href="/">戻る</a>
                </button>
                <button class="col-2 btn btn-outline-secondary mr-2" @click="_changePlayers">
                    交代
                </button>
                <button
                    v-if="isPost"
                    class="col-3 btn btn-outline-secondary"
                    @click="_onclick"
                >
                    一時保存
                </button>
                <button
                    v-if="!isPost"
                    class="col-4 btn btn-outline-secondary"
                    @click="_onclick"
                >
                    ダウンロード
                </button>
                <button
                    v-if="isPost"
                    class="btn btn-primary next-button ml-2 col-3"
                >
                    <a v-if="hasImage" href="/post/create" class="text-white"
                        >次へ</a
                    >
                    <label v-if="!hasImage" for="file_upload" class="mb-0"
                        >デバイスから選ぶ</label
                    >
                    <input
                        type="file"
                        name="file"
                        id="file_upload"
                        accept="image/*"
                        class="d-none"
                        v-if="!hasImage"
                        @change="upLoadImages"
                        multiple
                    />
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["isPost", "refererPath"],
    data: function () {
        return {
            hasImage: "",
        };
    },
    methods: {
        _onclick: function () {
            this.$emit("captureBoard");
        },
        _changePlayers: function () {
            this.$emit("_changePlayers");
        },
        _onClickText: function () {
            this.$emit("_onClickText");
        },
        _onClickRect: function () {
            this.$emit("_onClickRect");
        },
        _onClickLine: function (e) {
            e.target.classList.toggle("btn-drawing");
            this.$emit("_onClickLine");
        },
        _onClickDelete: function () {
            this.$emit("_onClickDelete");
        },
        upLoadImages: function (e) {
            this.$emit("upLoadImages", e);
        }
    },
};
</script>
