/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "cine-neutral": "#15161b",
                "cine-highlight-1": "#27d25b",
            },
        },
    },
    plugins: [require("@tailwindcss/typography"), require("daisyui")],
};
