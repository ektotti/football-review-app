<template>
    <div
        class="awayteam-players text-center"
        :class="className"
        :style="{ left: ElementLeft + 'px', top: ElementTop + 'px' }"
    >
        <div
            class="point"
            @mousedown="_onMouseDown"
            @mouseup="_onMouseUp"
            @mouseleave="_onMouseLeave"
        >
            <span class="number">{{ number }} </span>
        </div>
        <span class="name">{{ name }}</span>
    </div>
</template>
<script>
import { players } from "../players.js";
export default {
    mixins: [players],
};
</script>
