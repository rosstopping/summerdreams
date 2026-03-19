export default () => ({
    scrollDistance: 0,
    elementPosition: 0,
    windowHeight: 0,
    translateX: 0,
    onScroll() {
        // update the scroll distance
        this.scrollDistance = window.scrollY;

        // check if we've passed the threshold
        if (this.scrollDistance > this.elementPosition) {
            this.translateX = this.scrollDistance - this.elementPosition;
        }
        else {
            this.translateX = 0;
        }

        // update the style
        this.$root.style.transform = `translateX(-${this.translateX / 2}px)`;
    },
    init() {
        // get window height
        this.windowHeight = window.innerHeight;
        // get element position
        const el = this.$root.getBoundingClientRect();
        this.elementPosition = el.y - this.windowHeight - el.height;
    }
});