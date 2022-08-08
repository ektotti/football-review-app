<template>
    <div id="field" class="tactical-board-field justify-content-center">
        <HometeamPlayers
            v-for="(hometeamPlayer, key) in hometeamPlayers"
            :key="'home' + key"
            :class-name="hometeamPlayer.position"
            :number="hometeamPlayer.number"
            :name="hometeamPlayer.name | formatPlayerName"
        >
        </HometeamPlayers>
        <Ball></Ball>
        <AwayteamPlayers
            v-for="(awayteamPlayer, key) in awayteamPlayers"
            :key="'away' + key"
            :class-name="awayteamPlayer.position"
            :number="awayteamPlayer.number"
            :name="awayteamPlayer.name | formatPlayerName"
        >
        </AwayteamPlayers>
        <Canvas ref="canvas"></Canvas>
        <portal to="modal">
            <Modal :showModal="showModal">
                <ModalContentSetPostions
                    @contentBtnClick="setPlayers"
                    :hometeamPlayers="hometeamPlayers"
                    :awayteamPlayers="awayteamPlayers"
                    :hometeamName="hometeamName"
                    :awayteamName="awayteamName"
                ></ModalContentSetPostions>
            </Modal>
        </portal>
    </div>
</template>

<script>
import Canvas from "./Canvas.vue";
import HometeamPlayers from "./HometeamPlayers.vue";
import AwayteamPlayers from "./AwayteamPlayers.vue";
import Modal from "./Modal.vue";
import ModalContentSetPostions from "./ModalContentSetPostions.vue";
import Ball from "./Ball.vue";
import PortalVue from "portal-vue";
import html2canvas from "html2canvas";

Vue.use(PortalVue);
export default {
    props: ["isPost"],
    data: function () {
        return {
            hometeamPlayers: {},
            awayteamPlayers: {},
            hometeamName: "",
            awayteamName: "",
            showModal: false,
            images: [],
            startingMemberKeys: [
                "player_1",
                "player_2",
                "player_3",
                "player_4",
                "player_5",
                "player_6",
                "player_7",
                "player_8",
                "player_9",
                "player_10",
                "player_11",
            ],
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
            let canvasData = await canvas.toDataURL("image/jpeg"); //awaitいらないのでは？？

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
            this.hometeamPlayers = args[0][0];
            this.awayteamPlayers = args[0][1];
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
            let fileList = e.target.files;
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
        setPositionProp: function (players) {
            for (let key in players) {
                if (this.startingMemberKeys.includes(key)) {
                    players[key].postion = "";
                    console.log(players[key]);
                } else {
                    players[key].position = "RESERVE";
                }
            }
            return players;
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
            this.showModal = true;
        } catch (error) {
            console.log(error);
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
        ModalContentSetPostions,
    },
};
</script>
