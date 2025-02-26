{
  "version": 2,
  "builds": [
    { "src": "api/index.php", "use": "@vercel/php" },
    { "src": "api/(.*)", "use": "@vercel/php" }
  ],
  "routes": [
    { "src": "/(.*)", "dest": "/api/index.php" }
  ]
}
