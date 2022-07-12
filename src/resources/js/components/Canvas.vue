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
            // field: this.$el.parentElement,
        };
    },
    methods: {
        init() {
            this.canvas = new fabric.Canvas("cv");
            this.canvas.setWidth(field.clientWidth);
            this.canvas.setHeight(field.clientHeight);
            this.canvas.freeDrawingBrush.color = "rbg(0,0,0)";
            this.canvas.freeDrawingBrush.width = 2;
            this.canvas.freeDrawingBrush.strokeDashArray = [1, 1];
            this.canvas.selection = true;
            this.canvas.on("selection:created", function(){
                let deleteBtn = document.querySelector('#delete');
                deleteBtn.removeAttribute('disabled');
                // this.remove(this.getActiveObject())
            })
            this.canvas.on("selection:cleared", function(){
                let deleteBtn = document.querySelector('#delete');
                deleteBtn.setAttribute('disabled', null);
            })
        },
        // deleteObject: function(){
            
        // }
        _onClickText: function () {
            this.canvas.isDrawingMode = false;
            this.newText = new fabric.Textbox("テキストを入力してください", {
                left: 100,
                top: 100,
                height: 60,
                opacity: 1,
                // stroke: 'black',
                // strokeWidth: 0.5,
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
            if(this.canvas.isDrawingMode === true){
                this.canvas.isDrawingMode = false;
            } else {
                this.canvas.isDrawingMode = true;
            }
        },
        _onClickDelete: function () {
            let objects = this.canvas.getActiveObject();
            for(let object of objects._objects) {
                this.canvas.remove(object);
            }
        },
    },
    mounted() {
        this.init();
    },
};
</script>
