// fiveserver.config.js
const path = require("path");

module.exports = {
  php:
    process.platform === "win32"
      ? path.join("C:", "xampp", "php", "php.exe") // Windows
      : "/usr/bin/php", // macOS/Ubuntu
  php: "C:\\xampp\\php\\php.exe", // Windows`
};
