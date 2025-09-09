<?php require_once __DIR__ . '/../config.php' ?>
<?php $title = 'Contacts' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>

<main>
    <h1>Personal Contacts Page</h1>
    <div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-base font-semibold text-gray-900 dark:text-white">Users</h1>
      <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all the users in your account including their name, title, email and role.</p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
      <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Add Contact</button>
    </div>
  </div>
  <div class="mt-8 flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
          <thead>
            <tr>
              <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">First Name</th>
              <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Last Name</th>
              <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
              <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Phone Number</th>
              <th scope="col" class="py-3.5 pl-3 pr-4 sm:pr-0">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
          </thead>
          <tbody id="tbody" class="divide-y divide-gray-200 dark:divide-white/10">
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="flex justify-center space-x-2 mt-4">
    <button id="prevButton" onclick="prevPage()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
      ← Previous
    </button>
    <button id="nextButton" onclick="nextPage()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
      Next →
    </button>
</div>
</div>
</main>

<script src = "/contacts/read/get_page.js"></script>

<script>
  window.onload = loadContactTable(0);
  updatePaginationButtons();
</script>

<?php require_once COMPONENTS . '/layout/layout-bottom.php' ?>
