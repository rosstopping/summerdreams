export default () => ({
	slider: null,
	sliderMobile: null,
	scrollDistance: 0,
	textOpacity: 1,
	textScale: 1,
	textTransformY: 0,
	scrolledIntoPlace: false,
	eventTileOneScale: 0.8,
	eventTileOneSkewX: -4,
	eventTileOneSkewY: -1,
	eventTileTwoScale: 0.5,
	eventTileTwoSkewX: -4,
	eventTileTwoSkewY: -1,
	eventTileThreeScale: 0.5,
	eventTileThreeSkewX: 4,
	eventTileThreeSkewY: 1,
	eventTileFourScale: 0.8,
	eventTileFourSkewX: 4,
	eventTileFourSkewY: 1,
	onScroll() {
		// update the scroll distance
		this.scrollDistance = window.scrollY;

		/**
		 * Animate the welcome text
		 */
		if (this.scrollDistance > 0) {
			this.textOpacity = Math.max(0, 1 - this.scrollDistance / 500);
			this.textScale = Math.max(0, 1 - this.scrollDistance / 3000);
			this.textTransformY = this.scrollDistance / 10;

			this.eventTileOneScale = Math.min(1, 0.8 + this.scrollDistance / 1000);
			this.eventTileOneSkewX = Math.max(-4, Math.min(0, -4 + this.scrollDistance / 100));
			this.eventTileOneSkewY = Math.max(-1, Math.min(0, -1 + this.scrollDistance / 100));

			this.eventTileTwoScale = Math.min(1, 0.5 + this.scrollDistance / 1000);
			this.eventTileTwoSkewX = Math.max(-4, Math.min(0, -4 + this.scrollDistance / 100));
			this.eventTileTwoSkewY = Math.max(-1, Math.min(0, -1 + this.scrollDistance / 100));

			this.eventTileThreeScale = Math.min(1, 0.5 + this.scrollDistance / 1000);
			this.eventTileThreeSkewX = Math.min(4, Math.max(0, 4 - this.scrollDistance / 100));
			this.eventTileThreeSkewY = Math.min(1, Math.max(0, 1 - this.scrollDistance / 100));

			this.eventTileFourScale = Math.min(1, 0.8 + this.scrollDistance / 1000);
			this.eventTileFourSkewX = Math.min(4, Math.max(0, 4 - this.scrollDistance / 100));
			this.eventTileFourSkewY = Math.min(1, Math.max(0, 1 - this.scrollDistance / 100));
		}
		else {
			this.textOpacity = 1;
			this.textScale = 1;
			this.textTransformY = 0;
		}

		/**
		 * Check if we've scrolled into place
		 */
		if (this.scrollDistance >= this.$refs.scrollSpacing.offsetHeight - this.$refs.scroller.offsetHeight) {
			this.scrolledIntoPlace = true;
		}
		else {
			this.scrolledIntoPlace = false;
		}
	},
	initSlider(enabled = false) {
		if (this.slider) this.slider.destroy();
		if (this.sliderMobile) this.sliderMobile.destroy();

		// desktop slider
		this.slider = new Glide(this.$refs.glide, {
			dragThreshold: enabled ? 40 : false,
			swipeThreshold: enabled ? 40 : false,
			autoplay: enabled ? 3000 : false,
			type: 'carousel',
			hoverpause: true,
			infinite: true,
			perView: 4,
			gap: 40,
			breakpoints: {
				1200: {
					perView: 4,
					gap: 20,
				},
				640: {
					perView: enabled ? 4 : 4,
					gap: enabled ? 20 : 0,
				},
			},
		}).mount()

		// mobile slider
		this.sliderMobile = new Glide(this.$refs.glideMobile, {
			dragThreshold: enabled ? 40 : false,
			swipeThreshold: enabled ? 40 : false,
			autoplay: enabled ? 3000 : false,
			type: 'carousel',
			hoverpause: true,
			infinite: true,
			perView: 2,
			gap: 20,
		}).mount()
	},
	init() {
		this.initSlider();

		this.$watch('scrolledIntoPlace', value => value === true ? this.initSlider(true) : this.initSlider(false));
	}
});