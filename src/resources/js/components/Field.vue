<template>
    <div id="field" class="tactical-board-field justify-content-center">
        <HometeamPlayers
            v-for="(
                hometeamPlayersInPosition, key
            ) in hometeamPlayersInPositions"
            :key="'home' + key"
            :class-name="hometeamPlayersInPosition.position"
            :number="hometeamPlayersInPosition.number"
            :name="hometeamPlayersInPosition.name | formatPlayerName"
        >
        </HometeamPlayers>
        <Ball></Ball>
        <AwayteamPlayers
            v-for="(
                awayteamPlayersInPosition, key
            ) in awayteamPlayersInPositions"
            :key="'away' + key"
            :class-name="awayteamPlayersInPosition.position"
            :number="awayteamPlayersInPosition.number"
            :name="awayteamPlayersInPosition.name | formatPlayerName"
        >
        </AwayteamPlayers>
        <Canvas ref="canvas"></Canvas>
        <portal to="modal">
            <Modal
                @contentBtnClick="setPlayers"
                :showModal="showModal"
                :modalContent="'SetPostions'"
            >
            </Modal>
        </portal>
    </div>
</template>

<script>
import Canvas from "./Canvas.vue";
import HometeamPlayers from "./HometeamPlayers.vue";
import AwayteamPlayers from "./AwayteamPlayers.vue";
import Modal from "./Modal.vue";
import PortalVue from "portal-vue";
import html2canvas from "html2canvas";
import Ball from "./Ball.vue";
import Ball1 from "./Ball.vue";

Vue.use(PortalVue);
export default {
    props: ["isPost"],
    data: function () {
        return {
            hometeamPlayersInPositions: {},
            awayteamPlayersInPositions: {},
            showModal: true,
            images: [],
        };
    },
    computed: {
        hometeamPlayers: function () {
            let newArray = {};
            for (let key in this.initHometeamPlayers) {
                newArray[key] = {
                    name: this.initHometeamPlayers[key].name,
                    number: this.initHometeamPlayers[key].number,
                    position: "",
                };
            }
            return newArray;
        },
        awayteamPlayers: function () {
            let newArray = {};
            for (let key in this.initAwayteamPlayers) {
                newArray[key] = {
                    name: this.initAwayteamPlayers[key].name,
                    number: this.initAwayteamPlayers[key].number,
                    position: "",
                };
            }
            return newArray;
        },
    },
    methods: {
        capture: async function () {
            if (this.images.length >= 4) {
                alert("1度に投稿できる画像は4枚までです。");
                return;
            }

            let canvas = await html2canvas(this.$el, {
                scale: 2,
            });
            let canvasData = await canvas.toDataURL("image/jpeg");

            if (this.isPost) {
                this.images.push(canvasData);
                sessionStorage.setItem("images", JSON.stringify(this.images));
                alert("一時保存しました。");
                this.hasImage();
            } else {
                let downloadEl = document.createElement("a");
                downloadEl.setAttribute("href", canvasData);
                downloadEl.download = `football_review_app_${Date.now()}`;
                downloadEl.click();
            }
        },
        setPlayers: function (...args) {
            this.hometeamPlayersInPositions = args[0][0];
            this.awayteamPlayersInPositions = args[0][1];
            this.showModal = false;
        },
        removeImagesFromSession: function () {
            if (sessionStorage.getItem("images")) {
                sessionStorage.removeItem("images");
            } else {
                return;
            }
        },
        upLoadImages: async function (e) {
            let imagesFromSession =
                JSON.parse(sessionStorage.getItem("images")) ?? [];
            let fileList = e.target.files;
            if (imagesFromSession.length + fileList.length > 4) {
                alert("1度に投稿できる画像は4枚までです。");
                return;
            }
            for (let fileObj of fileList) {
                await this.fileReader(fileObj, this);
                console.log(this.image);
            }

            sessionStorage.setItem("images", JSON.stringify(this.images));

            let linkEl = document.createElement("a");
            linkEl.setAttribute("href", "/post/create");
            linkEl.click();
        },
        fileReader: function (fileObj, that) {
            return new Promise(function (resolve) {
                console.log("ここは？", that);
                let reader = new FileReader();
                reader.readAsDataURL(fileObj);
                reader.onload = function (e) {
                    that.images.push(e.target.result);
                    resolve();
                };
            });
        },
        hasImage: function () {
            this.$emit("hasImage");
        },
    },
    mounted: function () {
        this.removeImagesFromSession();
    },
    components: {
    HometeamPlayers,
    AwayteamPlayers,
    Modal,
    Canvas,
    Ball,
    Ball1
},
};
</script>
