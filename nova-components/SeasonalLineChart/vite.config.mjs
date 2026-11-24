import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath } from 'node:url'

export default defineConfig({
  plugins: [vue()],
  build: {
    lib: {
      entry: fileURLToPath(new URL('./resources/js/card.js', import.meta.url)),
      name: 'DigizuSeasonalLineChart',
      formats: ['iife'],
      cssFileName: 'card',
      fileName: () => 'js/card.js',
    },
    cssCodeSplit: false,
    rollupOptions: {
      external: ['vue'],
      output: {
        globals: { vue: 'Vue' },
        assetFileNames: asset => asset.names?.some(name => name.endsWith('.css')) ? 'css/card.css' : 'assets/[name][extname]',
      },
    },
  },
})
