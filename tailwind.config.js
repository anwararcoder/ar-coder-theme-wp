module.exports = {
  content: ["./**/*.php", "./**/*.twig", "./*.twig"],
  theme: {
    extend: {
      colors: {
        main: "#000",
      },
    },
  },
  plugins: [
    require("@tailwindcss/line-clamp"),
    require('@tailwindcss/typography'),
  ],
};