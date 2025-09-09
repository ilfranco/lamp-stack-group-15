<?php require_once __DIR__ . '/../../config.php' ?>
<?php $title = 'Register' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <a href="/" class="font-medium">Group 15's Personal Contact Manager</a>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">
                            Create an account
                        </h1>
                        <p class="text-center text-sm text-gray-500">Enter your details below to create your account</p>
                    </div>
                </div>
                <form id="registration-form" class="flex flex-col gap-2">

                    <div class="grid gap-2">
                        <label for="first_name" class="text-sm font-medium">First name</label>
                        <input id="first_name" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="First name" type="text" name="first_name" required />
                        <span class="text-right text-xs text-red-600 min-h-[1rem]" id="first_name_error"></span>
                    </div>
                    <div class="grid gap-2">
                        <label for="last_name" class="text-sm font-medium">Last name</label>
                        <input id="last_name" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="Last name" type="text" name="last_name" required />
                        <span class="text-right text-xs text-red-600 min-h-[1rem]" id="last_name_error"></span>
                    </div>
                    <div class="grid gap-2">
                        <label for="email" class="text-sm font-medium">Email Address</label>
                        <input id="email" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="email@example.com" type="email" name="email" required />
                        <span class="text-right text-xs text-red-600 min-h-[1rem]" id="email_error"></span>
                    </div>
                    <div class="grid gap-2">
                        <label for="password" class="text-sm font-medium">Password</label>
                        <input class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="Password" type="password" id="password" name="password" required />
                        <span class="text-right text-xs text-red-600 min-h-[1rem]" id="password_error"></span>
                    </div>
                    <div class="grid gap-2">
                        <label for="confirm_password" class="text-sm font-medium">Confirm password</label>
                        <input id="confirm_password" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="Confirm password" type="password" name="confirm_password" required >
                        <span class="text-right text-xs text-red-600 min-h-[1rem]" id="confirm_password_error"></span>
                    </div>
                    <button id="create_account" type="button" class="flex items-center justify-center gap-2 bg-gray-800 text-white px-4 py-3 rounded-md mt-4 text-sm cursor-pointer">
                        Create account
                    </button>
                    <div class="text-gray-400 text-center text-sm">
                        Already have an account? <a href="/auth/login" class="text-gray-700 underline decoration-neutral-300 underline-offset-4 hover:decoration-neutral-500 cursor-pointer transition-colors duration-300 ease-out">Log in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("create_account").addEventListener("click", async (event) => 
        {
            event.preventDefault();

            const formData = new FormData(document.getElementById("registration-form"));
            const data = Object.fromEntries(formData.entries());
            data.first_name = data.first_name.trim();
            data.last_name = data.last_name.trim();
            data.email = data.first_name.trim().toLowerCase();

            if (!data.first_name) 
                document.getElementById("first_name_error").textContent = "Required";

            if (!data.last_name) 
                document.getElementById("last_name_error").textContent = "Required";

            if (!data.email) 
                document.getElementById("email_error").textContent = "Required";

            if (data.password !== data.confirm_password) 
                document.getElementById("confirm_password_error").textContent = "Password mismatch";

            if (!data.last_name || !data.email || data.password !== data.confirm_password) 
                return;


            body = JSON.stringify(data);

            try 
            {
                const response = await fetch("/api/auth/register/", 
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
                        "message": "Success! User registered.",
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