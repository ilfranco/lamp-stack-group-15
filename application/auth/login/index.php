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
                <form action="/api/auth/login/" method="post" class="flex flex-col gap-6">
                    <div class="grid gap-2">
                        <label class="text-sm font-medium" for="email">Email Address</label>
                        <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        autocomplete="username"
                        class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md w-full"
                        placeholder="email@example.com"
                        />
                    </div>

                    <div class="grid gap-2">
                        <label class="text-sm font-medium" for="password">Password</label>
                        <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="border rounded-md border-gray-300 placeholder:text-gray-400 px-3 py-2 shadow-md w-full"
                        placeholder="••••••••"
                        />
                    </div>

                    <button type="submit" class="flex items-center justify-center gap-2 bg-gray-800 text-white px-4 py-2 rounded-md mt-4 text-sm">
                        Log in
                    </button>
                    <div class="text-gray-400 text-center text-sm mt-4">
                        Don't have an account?
                        <a href="/auth/register/" class="text-gray-700 underline decoration-neutral-300 underline-offset-4 hover:decoration-neutral-500 cursor-pointer transition-colors duration-300 ease-out">
                            Sign up
                        </a>
                    </div>

                    </form>
            </div>
        </div>
    </div>


   <script>
(() => {
  // Use your existing form that posts to /api/auth/login/
  const form = document.querySelector('form[action="/api/auth/login/"]');
  if (!form) return;

  const btn = form.querySelector('button[type="submit"]');

  // Helper to show messages: uses #login-msg if present, else alert()
  const showMsg = (t) => {
    const el = document.getElementById('login-msg');
    if (el) { el.textContent = t || ''; el.style.display = t ? 'block' : 'none'; }
    else if (t) { alert(t); }
  };

  form.addEventListener('submit', async (e) => {
    e.preventDefault();               // don't navigate to raw JSON
    showMsg('');

    const email = form.email.value.trim();
    const password = form.password.value;

    if (!email || !password) { showMsg('Please enter email and password.'); return; }

    // UI: disable button while sending
    if (btn) { btn.disabled = true; btn.classList.add('opacity-60','cursor-not-allowed'); }

    try {
      const res = await fetch(form.action, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
      });

      const data = await res.json().catch(() => ({}));

      if (!res.ok) {
        showMsg(data.error || 'Login failed.');
        if (btn) { btn.disabled = false; btn.classList.remove('opacity-60','cursor-not-allowed'); }
        return;
      }

      // Persist user (and token later if you add it)
      if (data.user) localStorage.setItem('user', JSON.stringify(data.user));
      if (data.token) localStorage.setItem('token', data.token);

      // Redirect 🎯
      window.location.href = '/contacts/';
    } catch {
      showMsg('Network error. Please try again.');
      if (btn) { btn.disabled = false; btn.classList.remove('opacity-60','cursor-not-allowed'); }
    }
  });
})();
</script>

 
<?php require_once COMPONENTS . '/layout/layout-bottom.php' ?>


