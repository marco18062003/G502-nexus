<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>g502 | Access Restricted</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #0f172a; /* Dark slate background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #f8fafc;
        }

        .container {
            text-align: center;
            padding: 2rem;
            border-radius: 12px;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid #334155;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
            max-width: 400px;
        }

        .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #fbbf24; /* Warning yellow */
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }

        p {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #38bdf8; /* Sky blue */
            color: #0f172a;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: transform 0.2s, background-color 0.2s;
        }

        .btn:hover {
            background-color: #7dd3fc;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="icon">⚠️</div>
        <h1>Feature Restricted</h1>
        <p>Right now, this function is not allowed or is currently under development for <strong>g502</strong>.</p>
        <a href="#" class="btn" onclick="window.history.back()">Go Back</a>
    </div>

</body>
</html>