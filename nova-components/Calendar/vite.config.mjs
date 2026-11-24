import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath } from 'node:url'

export default defineConfig({
  plugins: [vue()],
  build: {
    lib: {
      entry: fileURLToPath(new URL('./resources/js/tool.js', import.meta.url)),
      name: 'DigizuCalendar',
      formats: ['iife'],
      cssFileName: 'tool',
      fileName: () => 'js/tool.js',
    },
    cssCodeSplit: false,
    rollupOptions: {
      external: ['vue'],
      output: {
        globals: { vue: 'Vue' },
        assetFileNames: asset => asset.names?.some(name => name.endsWith('.css')) ? 'css/tool.css' : 'assets/[name][extname]',
      },
    },
  },
})
