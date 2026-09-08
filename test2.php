<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            margin: 0;
            padding: 40px;
            color: #1f2937;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #0f172a;
            text-align: center;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
        }

        .highlight {
            color: #2563eb;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to My PHP Page</h1>

        <?php
            $name = "Student";
            $course = "PRO204";
            echo "<p>Hello, <span class='highlight'>$name</span>!</p>";
            echo "<p>You are studying <span class='highlight'>$course</span>.</p>";
            echo "<p>This is a simple PHP page created for testing.</p>";
        ?>
    </div>
</body>
</html>
