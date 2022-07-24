<template>
    <canvas id="cv" class="px-0"></canvas>
</template>
<script>
import { fabric } from "fabric";
export default {
    data: function () {
        return {
            canvas: {},
            newRect: {},
            newText: {},
            field: {},
        };
    },
    methods: {
        init() {
            this.field = document.querySelector('#field');
            this.canvas = new fabric.Canvas("cv");
            this.canvas.setWidth(this.field.clientWidth);
            this.canvas.setHeight(this.field.clientHeight);
            this.canvas.freeDrawingBrush.color = "rbg(0,0,0)";
            this.canvas.freeDrawingBrush.width = 2;
            this.canvas.freeDrawingBrush.strokeDashArray = [1, 1];
            this.canvas.selection = true;
            this.canvas.on("selection:created", function () {
                let deleteBtn = document.querySelector("#delete");
                deleteBtn.removeAttribute("disabled");
            });
            this.canvas.on("selection:cleared", function () {
                let deleteBtn = document.querySelector("#delete");
                deleteBtn.setAttribute("disabled", null);
            });
        },
        _onClickText: function () {
            this.canvas.isDrawingMode = false;
            this.newText = new fabric.Textbox("テキストを入力してください", {
                left: 100,
                top: 100,
                height: 60,
                opacity: 1,
                fontWeight: "lighter",
                strokeUniform: false,
                backgroundColor: "#ffffff73",
                cornerStyle: "rect",
                color: "black",
                fontSize: 11,
                lockScalingY: true,
            });
            this.canvas.add(this.newText);
        },
        _onClickRect: function () {
            this.canvas.isDrawingMode = false;
            this.newRect = new fabric.Rect({
                left: 100,
                top: 100,
                width: 50,
                height: 50,
                fill: "black",
                opacity: 0.5,
                rx: 10,
                ry: 10,
                strokeUniform: true,
            });
            this.canvas.add(this.newRect);
            console.log(this.canvas);
        },
        _onClickLine: function () {
            console.log(this.field);
            if (this.canvas.isDrawingMode === true) {
                this.canvas.isDrawingMode = false;
            } else {
                this.canvas.isDrawingMode = true;
            }
        },
        _onClickDelete: function () {
            let activeObjects = this.canvas.getActiveObjects();
            if(activeObjects != null) {
                activeObjects.forEach(function(object) {
                    this.canvas.remove(object);
                }.bind(this));
            }
        },
    },
    mounted() {
        window.onload = () => {
            this.init();
        }
    },
};
</script>
