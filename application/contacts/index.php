<?php require_once __DIR__ . '/../config.php' ?>
<?php $title = 'Contacts' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>

<html lang ="en">
<main>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <!---<header class="header-bar">
    <h1 class="header-title">Personal Contacts</h1>
    <button id="logout-button" class="btn btn-logout">Logout</button>
  </header>--->
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold text-gray-900 dark:text-white">Contacts</h1>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <button type="button" id ="add-contact" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Add Contact</button>
      </div>
    </div>
    <div class="search-wrapper">
      <label for="search">Search Contacts</label>
      <input type="search" id="search" placeholder="Search contacts by name, email, or phone number..." class="mb-4 px-4 py-2 border rounded w-full">
      <button id="clear-search" class="mb-4 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded cursor-pointer">Clear</button>
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
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Date Created</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Date Updated</th>
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
      <button id="prevButton" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
        ← Previous
      </button>
      <button id="nextButton" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
        Next →
      </button>
    </div>
    <div id="page-indicator" class="text-sm text-gray-600 dark:text-gray-300 mt-2"></div>
  </div>
  <div id="edit-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Edit Contact</h2>
      <form id="edit-form">
        <input type="hidden" id="edit-id" />
        <div class="mb-4">
          <label for="edit-first-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
          <input type="text" id="edit-first-name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
          <span id="error-first-name" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
        </div>
        <div class="mb-4">
          <label for="edit-last-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
          <input type="text" id="edit-last-name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
          <span id="error-last-name" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
        </div>
        <div class="mb-4">
          <label for="edit-email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
          <input type="email" id="edit-email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
          <span id="error-email" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
        </div>
        <div class="mb-4">
          <label for="edit-phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
          <input type="text" id="edit-phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
          <span id="error-phone" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
        </div>
        <div class="flex justify-between">
          <button type="button" id="delete-contact" class="px-4 py-2 bg-red-600 text-white rounded cursor-pointer">Delete</button>
          <div class="flex space-x-2">
            <button type="button" id="cancel-edit" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded cursor-pointer">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded cursor-pointer">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div id="confirm-delete-modal" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden z-50">
  <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg max-w-sm w-full">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Confirm Deletion</h2>
    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">Are you sure you want to delete this contact? This action cannot be undone.</p>
    <div class="flex justify-end space-x-2">
      <button id="cancel-delete" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded cursor-pointer">Cancel</button>
      <button id="confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded cursor-pointer">Delete</button>
    </div>
  </div>
</div>
</main>

<script>
  //workaround until session page is implemented
  window.AppState = {
    currentPage: 0,
    isSearching: false,
    searchQuery: ""
  };
</script>

<script src = "/contacts/read/get_page.js"></script>
<script src = "/contacts/update/update.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
		
    loadContactTable();

    //Handle loading contacts
    document.getElementById("search").addEventListener("input", function () {
      const query = this.value.trim().toLowerCase();
      console.log(query);
      if (query === "") {
        window.AppState.isSearching = false;
        loadContactTable();
      } else {
        window.AppState.currentPage = 0;
        searchContacts(query);
      }
    });

    document.getElementById("clear-search").addEventListener("click", function () {
      window.AppState.isSearching = false;
      window.AppState.searchQuery = "";
      window.AppState.currentPage = 0;
      document.getElementById("search").value = "";
      loadContactTable(window.AppState.currentPage);
    });

    document.getElementById("add-contact").addEventListener("click", function () {
      window.location.href = "/contacts/create";
      loadContactTable(window.AppState.currentPage);
    });

    //Handle editing contact information
    document.getElementById("tbody").addEventListener("click", function(event) {
      const target = event.target.closest(".edit-btn");

      if (target) {
        event.preventDefault();
        const row = target.closest("tr");

        console.log(row);

        const contact = {
          id: row.getAttribute("data-id"),
          first_name: row.getAttribute("data-first-name").trim(),
          last_name: row.getAttribute("data-last-name").trim(),
          email: row.getAttribute("data-email").trim(),
          phone: row.getAttribute("data-phone").trim()
        };

        openEditForm(contact);
      }
    });

    document.getElementById("cancel-edit").addEventListener("click", function() {
      document.getElementById("error-first-name").setAttribute("hidden", "");
      document.getElementById("error-last-name").setAttribute("hidden", "");
      document.getElementById("error-email").setAttribute("hidden", "");
      document.getElementById("error-phone").setAttribute("hidden", "");
      document.getElementById("edit-modal").classList.add("hidden");
    });

    document.getElementById("edit-form").addEventListener("submit", function() {
      event.preventDefault();

      const updatedContact = {
        id: document.getElementById("edit-id").value.trim(),
        first_name: document.getElementById("edit-first-name").value.trim(),
        last_name: document.getElementById("edit-last-name").value.trim(),
        email: document.getElementById("edit-email").value.trim(),
        phone: document.getElementById("edit-phone").value.trim()
      };

      submitEditForm(updatedContact);
    });

    //Handle deletion
    const deleteButton = document.getElementById("delete-contact");
    const confirmModal = document.getElementById("confirm-delete-modal");
    const cancelDeleteButton = document.getElementById("cancel-delete");
    const confirmDeleteButton = document.getElementById("confirm-delete");

    let contactIdToDelete = null;

    deleteButton.addEventListener("click", function () {
      contactIdToDelete = document.getElementById("edit-id").value;
      confirmModal.classList.remove("hidden");
    });

    cancelDeleteButton.addEventListener("click", function () {
      confirmModal.classList.add("hidden");
      contactIdToDelete = null;
    });

    confirmDeleteButton.addEventListener("click", function () {
      deleteUser(contactIdToDelete);
    });

	}, false);
</script>

<?php require_once COMPONENTS . '/layout/layout-bottom.php' ?>
