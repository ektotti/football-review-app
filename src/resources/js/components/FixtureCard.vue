<template>
    <div class="col-10">
        <div class="card">
            <div class="card-header text-center">{{ listTitle }}</div>
            <ul v-if="fixtures.length" class="list-group list-group-flush">
                <li
                    class="list-group-item"
                    v-for="(fixture, index) in fixtures"
                    :key="index"
                >
                    <a
                        class="card-link row justify-content-center text-body"
                        :href="'/create/board?fixture_id=' + fixture.id"
                    >
                        <span class="card-text col-4 text-center">{{
                            fixture.hometeam_name
                        }}</span>
                        <span class="card-text col-3 text-center">VS</span>
                        <span class="card-text col-4 text-center">{{
                            fixture.awayteam_name
                        }}</span>
                    </a>
                </li>
                <li class="list-group-item">
                    <div class="row justify-content-center">
                        <button
                            class="btn col-6 text-center"
                            v-if="prevPageUrl"
                            @click="goPrevPage"
                        >
                            PREV
                        </button>
                        <button
                            class="btn col-6 text-center"
                            v-if="nextPageUrl"
                            @click="goNextPage"
                        >
                            NEXT
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import Axios from "axios";
export default {
    props: {
        listTitle: "",
        isComingSoon: "",
    },
    data: function () {
        return {
            fixtures: {},
            nextPageUrl: "",
            prevPageUrl: "",
        };
    },
    mounted: async function () {
        if (!this.isComingSoon) {
            let response = await Axios.get(
                "/api/fixture/recent"
            );
            console.log(response);
            this.fixtures = response.data.data;
            this.nextPageUrl = response.data.next_page_url;
            this.prevPageUrl = response.data.prev_page_url;
        }
        if (this.isComingSoon) {
            let response = await Axios.get(
                "/api/fixture/coming_soon"
            );
            this.fixtures = response.data.data;
            this.nextPageUrl = response.data.next_page_url;
            this.prevPageUrl = response.data.prev_page_url;
        }
        console.log(this.nextPageUrl);
    },
    methods: {
        goNextPage: async function () {
            let response = await Axios.get(this.nextPageUrl);
            this.fixtures = response.data.data;
            this.nextPageUrl = response.data.next_page_url;
            this.prevPageUrl = response.data.prev_page_url;
        },
        goPrevPage: async function () {
            let response = await Axios.get(this.prevPageUrl);
            this.fixtures = response.data.data;
            this.nextPageUrl = response.data.next_page_url;
            this.prevPageUrl = response.data.prev_page_url;
        },
    },
};
</script>
