<template>
    <div class="profiel-wrapper col-12">
        <div
            class="profiel-inner row col-8 justify-content-center mx-auto py-3"
        >
            <div class="profiel-inner-icon col-4">
                <img
                    class="rounded"
                    :src="selectedUser.icon_image"
                    alt="Icon"
                    width="150"
                />
            </div>
            <div class="profiel-inner-content col-8">
                <div class="upside row py-2 align-items-center">
                    <h2 class="mr-5 mb-0" v-if="selectedUser.nickname">
                        {{ selectedUser.nickname }}
                    </h2>
                    <h2 class="mr-5 mb-0" v-if="!selectedUser.nickname">
                        {{ selectedUser.name }}
                    </h2>
                    <div v-show="!isSelf">
                        <button
                            class="btn btn-primary mr-5"
                            @click="followUser"
                            v-if="!isFollowing"
                        >
                            フォローする
                        </button>
                        <button
                            class="btn btn-primary mr-5"
                            @click="unfollowUser"
                            v-if="isFollowing"
                        >
                            フォローをやめる
                        </button>
                    </div>
                    <div v-show="isSelf" class="row">
                        <a
                            :href="`/user/${selectedUser.id}/edit`"
                            class="btn btn-primary btn btn-primary mx-3"
                        >
                            プロフィール編集
                        </a>
                        <form action="/logout" method="post">
                            <input type="hidden" name="_token" :value="csrf" />
                            <input
                                type="submit"
                                value="ログアウト"
                                class="btn btn-primary"
                            />
                        </form>
                    </div>
                </div>
                <div class="under-side row py-4">
                    <div class="h4 mr-4 mb-0">
                        <span> {{ postAmount }} </span>
                        <span class="h4 mb-0"> 投稿 </span>
                    </div>
                    <div class="h4 mr-4 mb-0" @click="showFollows">
                        <span> {{ followingUserAmount }} </span>
                        <span> フォロー </span>
                    </div>
                    <div class="h4 mr-4 mb-0" @click="showFollowers">
                        <span> {{ followedUserAmount }} </span>
                        <span> フォロワー </span>
                    </div>
                </div>
            </div>
        </div>
        <portal to="modal">
            <Modal v-if="showModal">
                <RelationShipList
                    :args="args"
                    @contentBtnClick="showModal = false"
                ></RelationShipList>
            </Modal>
        </portal>
    </div>
</template>
<script>
import PortalVue from "portal-vue";
import Axios from "axios";
import RelationShipList from "./RelationShipList.vue";

Vue.use(PortalVue);
export default {
    props: {
        selectedUser: {},
        loginUser: {},
        isFollowing: "",
        isSelf: {
            default: false,
        },
    },
    data: function () {
        return {
            showModal: false,
            args: [],
            postAmount: this.selectedUser.posts.length,
            followingUserAmount: this.selectedUser.following_user.length,
            followedUserAmount: this.selectedUser.followed_user.length,
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        };
    },
    methods: {
        followUser: async function () {
            let response = await Axios.post(`/relationship/follow`, {
                selectedUserId: this.selectedUser.id,
                loginUserId: this.loginUser.id,
            });
            this.isFollowing = true;
            this.followedUserAmount += 1;
        },
        unfollowUser: async function () {
            let response = await Axios.post(`/relationship/unfollow`, {
                selectedUserId: this.selectedUser.id,
                loginUserId: this.loginUser.id,
            });
            if (response.data.delete) {
                this.isFollowing = false;
                this.followedUserAmount -= 1;
            }
        },
        showFollows: async function () {
            let response = await Axios.get(
                `/relationship/follow/${this.selectedUser.id}`
            );
            this.args.relationList = response.data.followList;
            this.args.relationType = "follow";
            console.log("profiel", this.args.relationList);
            this.showModal = true;
        },
        showFollowers: async function () {
            let response = await Axios.get(
                `/relationship/follower/${this.selectedUser.id}`
            );
            this.args.relationList = response.data.followerList;
            this.args.relationType = "follower";
            console.log(this.args.relationList);
            this.showModal = true;
        },
    },
    components: { RelationShipList },
};
</script>
