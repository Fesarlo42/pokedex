<?php if (isset($params['message']) && $params['message'] !== ''): ?>
  <div class="container mt-3">
    <div class="alert alert-primary"
      id="message-box">
      <?php echo htmlspecialchars($params['message']); ?>
    </div>
  </div>
<?php endif; ?>

<?php if (isset($params['errors']) && count($params['errors']) !== 0): ?>
  <div class="container mt-3">
    <div class="alert alert-danger"
      id="message-box">
      <?php foreach($params['errors'] as $error): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>