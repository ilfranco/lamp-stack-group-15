<?php require_once __DIR__ . '/../../config.php' ?>
<?php $title = 'Register' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <a href="/contacts" class="font-medium">Group 15's Personal Contact Manager</a>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">
                            Add a contact
                        </h1>
                        <p class="text-center text-sm text-gray-500">Enter your contacts details below</p>
                    </div>
                </div>
                <form id="contact_form" class="flex flex-col gap-2">

                    <div class="grid gap-2">
                        <label for="first_name" class="text-sm font-medium">First name</label>
                        <input id="first_name" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="First name" type="text" name="first_name" required />
                        <span id="first_name_error" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
                    </div>
                    <div class="grid gap-2">
                        <label for="last_name" class="text-sm font-medium">Last name</label>
                        <input id="last_name" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="Last name" type="text" name="last_name" required />
                        <span id="last_name_error" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
                    </div>
                    <div class="grid gap-2">
                        <label for="email" class="text-sm font-medium">Email Address</label>
                        <input id="email" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" placeholder="email@example.com" type="email" name="email" required />
                        <span id="email_error" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
                    </div>
                    <div class="grid gap-2">
                        <label for="phone" class="text-sm font-medium">Phone</label>
                        <input id="phone" class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md" maxlength=10 placeholder="111-222-3333" type="tel" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required />
                        <span id="phone_error" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
                    </div>
                    <button id="add_contact" type="button" class="flex items-center justify-center gap-2 bg-gray-800 text-white px-4 py-3 rounded-md mt-4 text-sm cursor-pointer">
                        Add contact
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("add_contact").addEventListener("click", async (event) => 
        {
            event.preventDefault();

            const formData = new FormData(document.getElementById("contact_form"));
            const data = Object.fromEntries(formData.entries());
            data.first_name = data.first_name.trim();
            data.last_name = data.last_name.trim();
            data.email = data.email.trim().toLowerCase();

            if (!data.first_name) 
                document.getElementById("first_name_error").textContent = "Please enter your contacts first name.";

            if (!data.last_name) 
                document.getElementById("last_name_error").textContent = "Please enter your contacts last name.";

            if (!data.email) 
                document.getElementById("email_error").textContent = "Please enter your contacts email.";

            if (!data.phone) 
                document.getElementById("phone_error").textContent = "Please enter your contacts phone number.";


            if (!data.first_name || !data.last_name || !data.email || !data.phone) 
                return;

            const body = JSON.stringify(data);

            console.log(body);

            try 
            {
                const response = await fetch("/api/contacts/create/", 
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