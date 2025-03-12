<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<form action="/resetPassword" method="POST">
    <input type="hidden" name="email" value="<?php echo $_SESSION['emailOne'] ?? ''; ?>">

    <label for="pin">Enter Your 6-Digit PIN</label>
    <input type="text" name="pin" required>

    <label for="password">New Password</label>
    <input type="password" name="password" required>

    <label for="confirm_password">Confirm Password</label>
    <input type="password" name="confirm_password" required>

    <button type="submit" class="btn">Reset Password</button>
</form>
