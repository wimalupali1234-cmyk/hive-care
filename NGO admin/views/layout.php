<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle ?? 'HIVeCare Admin'; ?></title>
  <meta name="description" content="<?php echo $pageDescription ?? 'HIV Services Management System'; ?>">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <?php if (isset($additionalCSS)): ?>
    <?php foreach ($additionalCSS as $css): ?>
      <link rel="stylesheet" href="<?php echo $css; ?>">
    <?php endforeach; ?>
  <?php endif; ?>
</head>
<body>
  <?php include __DIR__ . '/components/header.php'; ?>
  
  <main>
    <?php echo $content; ?>
  </main>
  
  <?php include __DIR__ . '/components/footer.php'; ?>
  
  <?php if (isset($additionalJS)): ?>
    <?php foreach ($additionalJS as $js): ?>
      <script src="<?php echo $js; ?>"></script>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
