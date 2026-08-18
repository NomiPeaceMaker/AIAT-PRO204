<?php
$resume = json_decode(file_get_contents(__DIR__ . '/resume.json'), true);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($resume['name']); ?> — Resume</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <header class="header">
      <h1><?php echo htmlspecialchars($resume['name']); ?></h1>
      <p class="title"><?php echo htmlspecialchars($resume['title']); ?></p>
      <p class="contact">
        <?php echo htmlspecialchars($resume['contact']['email']); ?> |
        <?php echo htmlspecialchars($resume['contact']['phone']); ?> |
        <?php echo htmlspecialchars($resume['contact']['location']); ?>
      </p>
    </header>

    <section class="summary">
      <h2>Summary</h2>
      <p><?php echo nl2br(htmlspecialchars($resume['summary'])); ?></p>
    </section>

    <section class="experience">
      <h2>Experience</h2>
      <?php foreach ($resume['experience'] as $job): ?>
        <div class="job">
          <h3><?php echo htmlspecialchars($job['title']); ?> — <?php echo htmlspecialchars($job['company']); ?></h3>
          <p class="dates"><?php echo htmlspecialchars($job['start']); ?> — <?php echo htmlspecialchars($job['end']); ?></p>
          <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
        </div>
      <?php endforeach; ?>
    </section>

    <section class="education">
      <h2>Education</h2>
      <?php foreach ($resume['education'] as $edu): ?>
        <div class="edu">
          <h3><?php echo htmlspecialchars($edu['degree']); ?> — <?php echo htmlspecialchars($edu['institution']); ?></h3>
          <p class="dates"><?php echo htmlspecialchars($edu['year']); ?></p>
        </div>
      <?php endforeach; ?>
    </section>

    <section class="skills">
      <h2>Skills</h2>
      <ul class="skills-list">
        <?php foreach ($resume['skills'] as $skill): ?>
          <li><?php echo htmlspecialchars($skill); ?></li>
        <?php endforeach; ?>
      </ul>
    </section>

    <footer>
      <p>Generated with a simple PHP template</p>
    </footer>
  </div>
</body>
</html>
