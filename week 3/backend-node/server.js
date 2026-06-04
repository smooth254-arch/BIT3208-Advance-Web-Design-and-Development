require('dotenv').config();
const express = require('express');
const mysql = require('mysql2/promise');
const app = express();
app.use(express.json());

// Basic CORS for local development
app.use((req, res, next) => {
  res.header('Access-Control-Allow-Origin', '*');
  res.header('Access-Control-Allow-Headers', 'Content-Type');
  if (req.method === 'OPTIONS') {
    res.header('Access-Control-Allow-Methods', 'GET,POST,OPTIONS');
    return res.sendStatus(200);
  }
  next();
});

const DB_CONFIG = {
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASS || '',
  database: process.env.DB_NAME || 'kicks_db',
};

let pool;

async function initDb() {
  pool = await mysql.createPool(DB_CONFIG);
  // Create shoes table if it doesn't exist
  await pool.query(`
    CREATE TABLE IF NOT EXISTS shoes (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      price VARCHAR(100) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  `);

  // Seed sample data if table empty
  const [rows] = await pool.query('SELECT COUNT(*) AS cnt FROM shoes');
  if (rows[0].cnt === 0) {
    const sample = [
      ['Versache', 'Ksh 4,500'],
      ['Airforce 1 Custom', 'Ksh 3,200'],
      ['Classic Loafers', 'Ksh 5,000'],
    ];
    await pool.query('INSERT INTO shoes (name, price) VALUES ?',[sample]);
  }
}

app.get('/api/shoes', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT id, name, price FROM shoes ORDER BY id');
    res.json(rows);
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'DB error' });
  }
});

app.post('/api/shoes', async (req, res) => {
  try {
    const { name, price } = req.body || {};
    if (!name || !price) return res.status(400).json({ error: 'name and price required' });
    const [result] = await pool.query('INSERT INTO shoes (name, price) VALUES (?, ?)', [name, price]);
    const [rows] = await pool.query('SELECT id, name, price FROM shoes WHERE id = ?', [result.insertId]);
    res.status(201).json(rows[0]);
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'DB error' });
  }
});

const port = process.env.PORT || 3000;
initDb().then(() => {
  app.listen(port, () => console.log(`Node API running at http://localhost:${port}`));
}).catch(err => {
  console.error('Failed to initialize DB:', err);
  process.exit(1);
});
