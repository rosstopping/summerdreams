export default (count) => ({
    count: count,
    delay: 4000,
    timer: null,
    current: 1,
    prev() {
        return this.current > 1 ? this.current : this.count - 1;
    },
    next() {
        return this.current < this.count ? this.current + 1 : 1;
    },
    change(x) {
        this.current = x;
        this.reset();
    },
    reset() {
        clearInterval(this.timer);
        this.timer = window.setInterval(() => {
            return this.current = this.current < this.count ? this.current + 1 : 1;
        }, this.delay);
    },
    init() {
        this.start();
    },
    start() {
        this.timer = window.setInterval(() => {
            this.current = this.current < this.count ? this.current + 1 : 1;
        }, this.delay);
    }
});