<template>
    <div
        class="text-center tactical-board-ball"
        :style="{ left: ElementLeft + 'px', top: ElementTop + 'px' }"
        @mousedown="_onMouseDown"
        @mouseup="_onMouseUp"
        @mouseleave="_onMouseLeave"
    ></div>
</template>
<script>
import { players } from "../players.js";
export default {
    mixins: [players],
};
</script>
