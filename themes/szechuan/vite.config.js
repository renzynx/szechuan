import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    server: {
        host: "127.0.0.1",
        port: 5173,
    },
    plugins: [
        laravel({
            input: [
                path.resolve(__dirname, "js/app.js"),
                path.resolve(__dirname, "css/app.css"),
            ],
            buildDirectory: "szechuan/",
            refresh: true,
        }),
        tailwindcss(),
    ],
});
