<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
  <div class="row">

    <?php include __DIR__ . '/../../includes/left.php'; ?>

    <main class="col-md-10 ms-sm-auto content-area">

      <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h2 class="m-0">Change Password</h2>
      </div>

      <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form method="post" action="change_password.php?a=update" style="max-width: 450px;">
        
        <div class="mb-3">
          <label class="form-label">Current Password *</label>
          <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">New Password *</label>
          <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Confirm New Password *</label>
          <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
      </form>

    </main>
  </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
