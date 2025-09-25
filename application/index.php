<?php require_once __DIR__ . '/config.php' ?>
<?php $title = 'Home' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>
    <div class="min-h-svh flex flex-col items-center justify-center px-8 bg-blue-100">
        <h1 class="text-center text-2xl">Welcome to Group 15's Personal Contact Manager</h1>
        <div class="text-center text-lg mt-6 space-x-4">
          <a href="/auth/login/" class="inline-block bg-blue-800 text-white py-3 px-6 rounded">
            Login
          </a>
          <span>or</span>
          <a href="/auth/register" class="inline-block bg-blue-800 text-white py-3 px-6 rounded">
            Register
          </a>
        </div>
    </div>
<?php require_once COMPONENTS . '/layout/layout-bottom.php' ?>
