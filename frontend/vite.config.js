import { fileURLToPath, URL } from "url";
import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  server: {
    port: 3000,
    strictPort: true,
    proxy: {
      // Proxy para autenticación y API de Laravel
      "/login": {
        target: "http://127.0.0.1:8081",
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/login/, "/login"),
      },
      "/logout": {
        target: "http://127.0.0.1:8081",
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/logout/, "/logout"),
      },
      "/sanctum": {
        target: "http://127.0.0.1:8081",
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/sanctum/, "/sanctum"),
      },
      "/api": {
        target: "http://127.0.0.1:8081",
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/api/, "/api"),
      },
      "/admin": {
        target: "http://127.0.0.1:8081",
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/admin/, "/admin"),
      },
    },
  },
});
