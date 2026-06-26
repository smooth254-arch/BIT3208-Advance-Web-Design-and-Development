# Week 3 — Backends (PHP + Node)

This folder contains two minimal backends you can run locally for development and testing.

PHP API (no dependencies)

- File: week 3/backend-php/api.php
- Start a PHP dev server from the repository root:

```powershell
cd "c:\Xampp2\htdocs\Kicks collection1\week 3"
& "C:\Xampp2\php\php.exe" -S localhost:8001
```

Then access the PHP endpoint: http://localhost:8001/backend-php/api.php

Node.js API (Express)

- Files: week 3/backend-node/server.js and package.json
- From the folder `week 3\backend-node` run:

```powershell
cd "c:\Xampp2\htdocs\Kicks collection1\week 3\backend-node"
npm install
npm start
```

Then access the Node API at: http://localhost:3000/api/shoes

Database integration

- The Node API can persist shoes to the `kicks_db` MySQL database used by the PHP app. It connects with user `root` and an empty password on `localhost` by default.
- On startup the Node server creates a `shoes` table if missing and seeds sample items if the table is empty.
- If your MySQL uses a different user/password, edit `week 3/backend-node/server.js` and modify `DB_CONFIG`.
Environment and configs

- You can configure the Node backend via a `.env` file in `week 3/backend-node` (example: `.env.example`). The Node server uses `dotenv` if present.
- PHP will read `NODE_API_URL` from the environment (or use `http://localhost:3000` by default). To set it for Apache/XAMPP, configure the environment or edit `week 3/backend-php/config.php`.

Frontend demo

- `week 3/frontend/index.html` fetches `http://localhost:3000/api/shoes` and displays items.

Install new Node dependency for `.env` support:

```powershell
cd "c:\Xampp2\htdocs\Kicks collection1\week 3\backend-node"
npm install dotenv
npm start
```

Notes
- These are simple example backends (no database). They return JSON and accept POSTs to add items in-memory only.
- If you want me to wire the PHP backend to your existing MySQL (`kicks_db`) I can add that next.
