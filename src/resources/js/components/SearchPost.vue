<template>
    <li class="input-group input-group-sm">
        <div class="input-group-prepend">
            <a :href="`/?tag_name=${tagName}`" class="input-group-text" id="search-post">
                <i class="fa-solid fa-magnifying-glass fa-sm"></i>
            </a>
        </div>
        <input
            type="text"
            class="form-control"
            aria-describedby="search-post"
            placeholder="#で検索"
            v-model="tagName"
        />
    </li>
</template>
<script>
export default {
    data: function () {
        return {
            tagName: '',
        };
    },
}
</script>
