<?php require_once __DIR__ . '/config.php' ?>
<?php $title = 'Home' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>
    <div class="py-36 px-8">
        <h1 class="text-center text-2xl">Welcome to Group 15's Personal Contact Manager</h1>
        <div class="text-center text-sm mt-6">
            <button class="text-white bg-gray-800 py-1 px-6 rounded cursor-pointer">
                <a href="/auth/login/">
                    Login
                </a>
            </button>
            <span class="mx-3">or</span> 
            <button class="text-white bg-gray-800 py-1 px-4 rounded">
                <a href="/auth/register">
                    Register
                </a>
            </button>
        </div>
    </div>
<?php require_once COMPONENTS . '/layout/layout-bottom.php' ?>
