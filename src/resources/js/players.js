export const players = {
    props: ["number", "name", "className"],
    data: function () {
        return {
            moveStart: false,
            ElementTop: "",
            ElementLeft: "",
            offsetTop: "",
            offsetLeft: "",
        };
    },
    methods: {
        _onMouseDown: function ($e) {
            this.moveStart = false;
            $e.target.classList.add("mouseDowned");
            console.log($e.offsetY);
            console.log(this.$parent.$el.getBoundingClientRect().top);
            this.offsetTop =
                $e.offsetY + this.$parent.$el.getBoundingClientRect().top + 5
            this.offsetLeft =
                $e.offsetX + this.$parent.$el.getBoundingClientRect().left + 5
            document.querySelector('#field').addEventListener('mousemove',this._onMouseMove);
        },
        _onMouseMove: function ($e) {
                this.ElementTop = $e.clientY - this.offsetTop;
                this.ElementLeft = $e.clientX - this.offsetLeft;
                document.querySelector('#field').addEventListener('mounseup',this._onMouseUp);
        },
        _onMouseUp: function ($e) {
            this.moveStart = false;
            document.querySelector('#field').removeEventListener('mousemove',this._onMouseMove);
            $e.target.classList.remove("mouseDowned");
            this.ElementTop += 10
            this.ElementLeft += 10;

        },
        _onMouseLeave: function () {
            if (this.moveStart) {
                this.moveStart = false;
            }
        },
    },
}