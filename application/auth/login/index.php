<?php require_once __DIR__ . '/../../config.php' ?>
<?php $title = 'Log in' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <a href="/" class="font-medium">Group 15's Personal Contact Manager</a>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">
                            Log in to your account
                        </h1>
                        <p class="text-center text-sm text-gray-500">Enter your email and password below to log in</p>
                    </div>
                </div>
                <form class="flex flex-col gap-6">
                    <div class="grid gap-2">
                        <label class="text-sm font-medium" for="email">Email Address</label>
                        <input class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-1 shadow-md" placeholder="email@email.com" type="email" id="email" required >
                    
                        </input>
                    </div>
                    <div class="grid gap-2">
                        <label class="text-sm font-medium" for="password">Password</label>
                        <input class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-1 shadow-md" placeholder="Password" type="email" id="password" required >
                    
                        </input>
                    </div>
                    <button class="flex items-center justify-center gap-2 bg-gray-800 text-white px-4 py-2 rounded-md mt-4 text-xs cursor-pointer">
                        Log in
                    </button>
                    <div class="text-gray-400 text-center text-sm">
                        Don't have an account? <a href="/auth/register" class="text-gray-700 underline decoration-neutral-300 underline-offset-4 hover:decoration-neutral-500 cursor-pointer transition-colors duration-300 ease-out">Sign up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require_once COMPONENTS . '/layout/layout-bottom.php' ?>