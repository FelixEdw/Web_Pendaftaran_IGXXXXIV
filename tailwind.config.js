/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
    safelist: [
    "cursor-[url('/images/cursor.png'),_pointer]"
  ],
  theme: {
    extend: {
      colors: {
        unlock: "#A8814F",
      },
    },
  },
  plugins: [],
}
