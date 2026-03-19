export default (images) => ({
    current: null,
    images: images,
    fullscreen: false,
    prev() {
        return this.current > 0 ? this.current - 1 : this.images.length - 1;
    },
    next() {
        return this.current < this.images.length - 1 ? this.current + 1 : 0;
    },
    change(x) {
        this.current = x;
    },
    expand(x)
    {
        this.current = x;
        this.fullscreen = true;
    },
    exit()
    {
        this.fullscreen = false;
    }
});