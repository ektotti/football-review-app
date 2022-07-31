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
            <Modal v-if="showModal">
                <SetPostions
                    @contentBtnClick="setPlayers"
                    :homeTeamPlayers="homeTeamPlayers"
                    :awayteamPlayers="awayteamPlayers"
                    :hometeamName="hometeamName"
                    :awayteamName="awayteamName"
                ></SetPostions>
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
import SetPostions from "./SetPostions.vue";

Vue.use(PortalVue);
export default {
    props: ["isPost"],
    data: function () {
        return {
            hometeamPlayers: {},
            awayteamPlayers: {},
            hometeamName,
            awayteamName,
            showModal: true,
            images: [],
        };
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
            let canvasData = await canvas.toDataURL("image/jpeg");//awaitいらないのでは？？

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
            console.log(this.showModal);
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
            let   fileList = e.target.files;
            if (imagesFromSession.length + fileList.length > 4) {
                alert("1度に投稿できる画像は4枚までです。");
                return;
            }
            for (let fileObj of fileList) {
                await this.fileReader(fileObj, this);
            }

            sessionStorage.setItem("images", JSON.stringify(this.images));

            let linkEl = document.createElement("a");
            linkEl.setAttribute("href", "/post/create");
            linkEl.click();
        },
        fileReader: function (fileObj, that) {
            return new Promise(function (resolve) {
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
    mounted: async function () {
        this.removeImagesFromSession();
        try {
            let fixtureIdParam = location.search;
            let response = await axios.get(`/api/players${fixtureIdParam}`);
            this.hometeamPlayers = response.data.players.hometeamPlayers;
            this.awayteamPlayers = response.data.players.awayteamPlayers;
            this.hometeamPlayers = this.setPositionProp(this.hometeamPlayers);
            this.awayteamPlayers = this.setPositionProp(this.awayteamPlayers);
            this.hometeamName = response.data.hometeamName;
            this.awayteamName = response.data.awayteamName;
        } catch (error) {
            alert(
                "playerが取得出来ませんでした。時間をおいてやり直して見て下さい。"
            );
            location.href = "/";
        }
    },
    components: {
        HometeamPlayers,
        AwayteamPlayers,
        Modal,
        Canvas,
        Ball,
        Ball1,
        SetPostions,
    },
};
</script>
