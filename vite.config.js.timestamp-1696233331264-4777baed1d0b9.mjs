// vite.config.js
import { defineConfig } from "file:///Users/rosstopping/Code/summerdreams/node_modules/vite/dist/node/index.js";
import laravel from "file:///Users/rosstopping/Code/summerdreams/node_modules/laravel-vite-plugin/dist/index.mjs";
import { ViteImageOptimizer } from "file:///Users/rosstopping/Code/summerdreams/node_modules/vite-plugin-image-optimizer/dist/index.mjs";
import viteWebfontDownload from "file:///Users/rosstopping/Code/summerdreams/node_modules/vite-plugin-webfont-dl/dist/index.mjs";
import mjml from "file:///Users/rosstopping/Code/summerdreams/node_modules/vite-plugin-mjml/dist/index.mjs";
var vite_config_default = defineConfig({
  plugins: [
    ViteImageOptimizer(),
    viteWebfontDownload([
      "https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap",
      "https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    ]),
    mjml({
      input: "resources/mail/mjml",
      output: "resources/views/mail",
      extension: ".blade.php"
    }),
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
      valetTls: "summerdreams.test"
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvVXNlcnMvcm9zc3RvcHBpbmcvQ29kZS92dmlwZXZlbnRzemFudGVcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIi9Vc2Vycy9yb3NzdG9wcGluZy9Db2RlL3Z2aXBldmVudHN6YW50ZS92aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vVXNlcnMvcm9zc3RvcHBpbmcvQ29kZS92dmlwZXZlbnRzemFudGUvdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IHsgVml0ZUltYWdlT3B0aW1pemVyIH0gZnJvbSAndml0ZS1wbHVnaW4taW1hZ2Utb3B0aW1pemVyJztcbmltcG9ydCB2aXRlV2ViZm9udERvd25sb2FkIGZyb20gJ3ZpdGUtcGx1Z2luLXdlYmZvbnQtZGwnO1xuaW1wb3J0IG1qbWwgZnJvbSAndml0ZS1wbHVnaW4tbWptbCdcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIFZpdGVJbWFnZU9wdGltaXplcigpLFxuICAgICAgICB2aXRlV2ViZm9udERvd25sb2FkKFtcbiAgICAgICAgICAgICdodHRwczovL2ZvbnRzLmdvb2dsZWFwaXMuY29tL2NzczI/ZmFtaWx5PUZpcmErU2FuczppdGFsLHdnaHRAMCwzMDA7MCw0MDA7MCw1MDA7MCw2MDA7MCw3MDA7MCw4MDA7MSwzMDA7MSw0MDA7MSw1MDA7MSw2MDA7MSw3MDA7MSw4MDAmZGlzcGxheT1zd2FwJyxcbiAgICAgICAgICAgICdodHRwczovL2ZvbnRzLmdvb2dsZWFwaXMuY29tL2NzczI/ZmFtaWx5PUludGVyOndnaHRAMzAwOzQwMDs1MDA7NjAwOzcwMDs4MDAmZGlzcGxheT1zd2FwJyxcbiAgICAgICAgXSksXG4gICAgICAgIG1qbWwoe1xuICAgICAgICAgICAgaW5wdXQ6ICdyZXNvdXJjZXMvbWFpbC9tam1sJyxcbiAgICAgICAgICAgIG91dHB1dDogJ3Jlc291cmNlcy92aWV3cy9tYWlsJyxcbiAgICAgICAgICAgIGV4dGVuc2lvbjogJy5ibGFkZS5waHAnLFxuICAgICAgICB9KSxcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogWydyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLCAncmVzb3VyY2VzL2pzL2FwcC5qcyddLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgICAgIHZhbGV0VGxzOiAndnZpcGV2ZW50c3phbnRlLnRlc3QnLCBcbiAgICAgICAgfSksXG4gICAgXSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUF1UyxTQUFTLG9CQUFvQjtBQUNwVSxPQUFPLGFBQWE7QUFDcEIsU0FBUywwQkFBMEI7QUFDbkMsT0FBTyx5QkFBeUI7QUFDaEMsT0FBTyxVQUFVO0FBRWpCLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLFNBQVM7QUFBQSxJQUNMLG1CQUFtQjtBQUFBLElBQ25CLG9CQUFvQjtBQUFBLE1BQ2hCO0FBQUEsTUFDQTtBQUFBLElBQ0osQ0FBQztBQUFBLElBQ0QsS0FBSztBQUFBLE1BQ0QsT0FBTztBQUFBLE1BQ1AsUUFBUTtBQUFBLE1BQ1IsV0FBVztBQUFBLElBQ2YsQ0FBQztBQUFBLElBQ0QsUUFBUTtBQUFBLE1BQ0osT0FBTyxDQUFDLHlCQUF5QixxQkFBcUI7QUFBQSxNQUN0RCxTQUFTO0FBQUEsTUFDVCxVQUFVO0FBQUEsSUFDZCxDQUFDO0FBQUEsRUFDTDtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
