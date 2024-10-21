// fiveserver.config.js

module.exports = {
  php:
    process.platform === "win32"
      ? path.join("C:", "xampp", "php", "php.exe") // Windows
      : "/usr/bin/php", // macOS/Ubuntu
};
