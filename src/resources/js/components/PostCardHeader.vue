<template>
    <div class="card-header" id="post-card-header">
        <div
            class="card-body py-0 row justify-content-between align-items-center"
        >
            <a class="text-body bg-transparent col-3 row px-0 align-items-center" :href="'/user/' + post.user.id">
                <div class="profiel-inner-icon">
                    <img
                        class="rounded"
                        :src="post.user.icon_image"
                        alt="Icon"
                        width="40"
                    />
                </div>
                <span
                    class="bg-transparent col-8 px-0"
                    v-if="post.user.nickname"
                    >{{ post.user.nickname }}</span
                >
                <span
                    class="bg-transparent col-8 px-0"
                    v-if="!post.user.nickname"
                    >{{ post.user.name }}</span
                >
            </a>
            <h3 class="col-6 mb-0 h5 text-center px-2">{{ post.title }}</h3>
            <a
                class="col-3 px-0 justify-content-center btn"
                :href="'/create/board?fixture_id=' + post.fixture.id"
            >
                <div class="row col-12 px-2 m-0">
                    <span class="col-5 px-0 text-center">{{
                        post.fixture.hometeam_name
                    }}</span>
                    <span class="col-2 px-0 text-center">VS</span>
                    <span class="col-5 px-0 text-center">{{
                        post.fixture.awayteam_name
                    }}</span>
                </div>
            </a>
            <!-- <span class="col-4">{{post.fixture.hometeam_name}}vs{{post.fixture.awayteam_name}}</span> -->
        </div>
    </div>
</template>
<script>
export default {
    props: {
        post: {},
    },
};
</script>
