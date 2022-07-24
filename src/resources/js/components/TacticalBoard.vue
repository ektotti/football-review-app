<template>
    <div class="tactical-board row flex-column align-items-center">
        <field ref="field" :isPost="isPost" @hasImage="hasImage"></field>
        <tactical-board-buttons
            @captureBoard="captureBoard"
            @_changePlayers="_changePlayers"
            @_onClickText="_onClickText"
            @_onClickRect="_onClickRect"
            @_onClickLine="_onClickLine"
            @_onClickDelete="_onClickDelete"
            @upLoadImages="upLoadImages"
            :isPost="isPost"
            ref="buttons"
        ></tactical-board-buttons>
    </div>
</template>
<script>
export default {
    props: ["isPost"],
    data: function () {
        return {
            canvas: this.$refs,
        };
    },
    methods: {
        captureBoard: function () {
            this.$refs.field.capture();
        },
        _changePlayers: function () {
            this.$refs.field.$data.showModal = true;
        },
        _onClickText: function () {
            this.$refs.field.$refs.canvas._onClickText();
        },
        _onClickRect: function () {
            this.$refs.field.$refs.canvas._onClickRect();
        },
        _onClickLine: function () {
            this.$refs.field.$refs.canvas._onClickLine();
        },
        _onClickDelete: function () {
            this.$refs.field.$refs.canvas._onClickDelete();
        },
        upLoadImages: function (e) {
            console.log('ボード',e);
            this.$refs.field.upLoadImages(e);
        },
        hasImage: function () {
            console.log("hasImage");
            console.log(this.$refs.buttons.hasImage);
            this.$refs.buttons.hasImage = true;
        },
    },
    mounted: function () {
        console.log(this.isPost);
    }
};
</script>
