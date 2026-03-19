import './bootstrap';

import * as Sentry from "@sentry/browser";

Sentry.init({
  dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
});

import.meta.glob([
  '../images/**',
]);

/**
 * Custom plugins
 **/
import gallery from './components/gallery.js'
import scroller from './components/scroller.js'
import slideshow from './components/slideshow.js'
import hero from './components/hero.js'

Alpine.data('gallery', gallery)
Alpine.data('scroller', scroller)
Alpine.data('slideshow', slideshow)
Alpine.data('hero', hero)

/**
 * Alpine Plugins 
 **/
import intersect from '@alpinejs/intersect'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'

Alpine.plugin(intersect)
Alpine.plugin(collapse)
Alpine.plugin(focus)

/**
 * Start Alpine
 **/
Alpine.start()

/**
 * Start Sal
 **/
sal({
  threshold: 0.25,
  once: true,
});