<?php
$weeks = [
    'Week 1&2' => 'Week 1&2/homepage.php',
    'week 3' => 'week 3/index.php',
    'Week 4' => 'Week 4/index.html',
    'Week 5' => 'Week 5/index.php',
    'Week 6' => 'Week 6/index.php',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kicks Collection1 | Project Home</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #0f172a;
            color: #f8fafc;
        }
        .page {
            max-width: 960px;
            margin: 0 auto;
            padding: 48px 24px;
        }
        .brand {
            font-size: 2rem;
            margin-bottom: 12px;
            color: #38bdf8;
        }
        .intro {
            font-size: 1rem;
            line-height: 1.7;
            color: #cbd5e1;
            margin-bottom: 32px;
            max-width: 760px;
        }
        .weeks {
            display: grid;
            gap: 16px;
            margin-top: 24px;
        }
        .week-card {
            padding: 22px 24px;
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.82);
            border: 1px solid rgba(96, 165, 250, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .week-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(56, 189, 248, 0.18);
        }
        .week-card a {
            color: #7dd3fc;
            font-size: 1.1rem;
            text-decoration: none;
            font-weight: bold;
        }
        .week-card p {
            margin: 8px 0 0;
            color: #cbd5e1;
        }
        .footer {
            margin-top: 40px;
            color: #94a3b8;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="brand">Kicks Collection1</div>
        <p class="intro">This project contains working site folders for Week 1&2 through Week 6. Use the links below to open the Week 1&2 homepage first and then navigate across the available weeks.</p>

        <div class="weeks">
            <?php foreach ($weeks as $label => $path): ?>
                <div class="week-card">
                    <a href="<?php echo htmlspecialchars($path, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?> &rsaquo; Open</a>
                    <p>Path: <?php echo htmlspecialchars($path, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="footer">
            If a link does not open, please verify that Apache is running and use the browser URL exactly as shown in the address bar.
        </div>
    </div>
</body>
</html>
