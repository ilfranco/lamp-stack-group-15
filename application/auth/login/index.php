<?php require_once __DIR__ . '/../../config.php' ?>
<?php $title = 'Log in' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 bg-blue-100">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <a href="/" class="font-medium">Group 15's Personal Contact Manager</a>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">
                            Log in to your account
                        </h1>
                        <p class="text-center text-sm text-gray-700">Enter your email and password below to log in</p>
                    </div>
                </div>
                <form id="login_form" class="flex flex-col gap-2">
                    <!-- <div class="grid gap-2">
                        <div class="flex justify-between">
                            <label for="email" class="text-sm font-medium">Email Address</label>
                            <span class="text-xs text-red-600 flex flex-col justify-end" id="email_error">Hedas</span>
                        </div>
                        <input id="email" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="email@example.com" type="email" name="email" required />
                    </div>  -->
                    <div class="grid gap-2">
                        <label for="email" class="text-sm font-medium">Email Address</label>
                        <input id="email" class="border rounded-md border-gray-400 placeholder:text-gray-400 px-3 py-2 shadow-md bg-white" placeholder="email@example.com" type="email" name="email" required />
                        <span id="email_error" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
                    </div>
                    <div class="grid gap-2">
                        <label for="password" class="text-sm font-medium">Password</label>
                        <input id="password" class="border rounded-md border-gray-400 placeholder:text-gray-400 px-3 py-2 shadow-md bg-white" placeholder="Password" type="password" name="password" required />
                        <span id="password_error" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
                    </div>
                    <button id="log_in" type="button" class="flex items-center justify-center gap-2 bg-blue-800 hover:bg-blue-900 text-white px-4 py-3 rounded-md mt-4 text-sm cursor-pointer">
                        Log in
                    </button>
                    <div class="text-gray-700 text-center text-sm">
                        Don't have an account? <a href="/auth/register" class="text-gray-700 underline decoration-neutral-400 underline-offset-4 hover:decoration-neutral-700 cursor-pointer transition-colors duration-300 ease-out">Sign up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("log_in").addEventListener("click", async (event) => 
        {
            event.preventDefault();

            const formData = new FormData(document.getElementById("login_form"));
            const data = Object.fromEntries(formData.entries());
            data.email = data.email.trim().toLowerCase();

            if (!data.email) 
                document.getElementById("email_error").textContent = "Please enter your email.";

            if (!data.password) 
                document.getElementById("password_error").textContent = "Please enter your password.";

            if (!data.email || !data.password) 
                return;


            const body = JSON.stringify(data);

            try 
            {
                const response = await fetch("/api/auth/login/", 
                {
                    method: "POST",
                    headers: {"Content-Type": "application/json"},
                    body: body
                });

                if (response.ok) // If (response.status >= 200) && (response.status <= 299)
                {
                    const data = await response.json();
                    /* 
                    data = {
                        "message": "Success! User logged in.",
                        "user": {
                            "id": integer,
                            "first_name": string,
                            "last_name": string, 
                        }
                    }*/
                    window.location.href = "/contacts/"
                }
                else // If (response.status < 200) || (response.status > 299)
                {
                    const error = await response.json();
                    error.status = response.status;
                    error.statusText = response.statusText;
                    throw error;
                }
            } 
            catch (error)
            {
                // Error handling coming soon!
            }
        });
    </script>



<?php require_once COMPONENTS . '/layout/layout-bottom.php' ?>


