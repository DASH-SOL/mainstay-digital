/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./templates/**/*.twig", "./assets/js/**/*.js", "./**/*.php"],
  theme: {
    extend: {
      colors: {
        mainstay: {
          primary: "#2c3e50",
          secondary: "#3498db",
          accent: "#e74c3c",
          dark: "#1a252f",
          light: "#ecf0f1",
          green: "#0EDD7A",
          "green-border": "#00B76C",
        },
      },
      fontFamily: {
        sans: [
          "Rubik",
          "-apple-system",
          "BlinkMacSystemFont",
          "Segoe UI",
          "Roboto",
          "sans-serif",
        ],
        rubik: ["Rubik", "Helvetica", "Arial", "Lucida", "sans-serif"],
      },
      spacing: {
        18: "4.5rem",
        88: "22rem",
        112: "28rem",
      },
      maxWidth: {
        site: "1340px",
      },
      container: {
        center: true,
        padding: "1rem",
        screens: {
          sm: "640px",
          md: "768px",
          lg: "1024px",
          xl: "1280px",
          "2xl": "1340px",
        },
      },
      boxShadow: {
        mainstay: "7px 7px 0px -1px #0edd7a",
        "mainstay-hover": "5px 5px 0px -1px #0edd7a",
      },
    },
  },
  plugins: [],
};
