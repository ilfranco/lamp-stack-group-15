<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /auth/login');
        exit;
    }
?>

<?php require_once __DIR__ . '/../config.php' ?>

<?php $title = 'Contacts' ?>

<?php require_once COMPONENTS . '/layout/layout-top.php' ?>

<link rel="stylesheet" href="styles.css">
  <header class="header-bar">
    <h1 class="header-title">Personal Contacts</h1>
    <button id="logout-button" class="btn btn-logout">Logout</button>
  </header>

  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold text-gray-900 dark:text-white">Your Contacts</h1>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <button onclick="open_add_contact_form()" type="button" id ="add-contact" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">Add Contact</button>
      </div>
    </div>

    <div class="search-wrapper flex items-center">
      <input type="search" id="search" placeholder="Search contacts by name, email, or phone number..." class="mb-4 px-4 py-2 border rounded w-full">
      <button id="clear-search" class="mb-4 px-4 py-2 bg-blue-200 hover:bg-blue-300 rounded cursor-pointer">Clear</button>
    </div>

    <div class="mt-4 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="relative min-w-full divide-y divide-gray-500 dark:divide-white/15">
            <thead class="bg-gray-200 rounded-tl-2x1 rounded-tr">
              <tr>
                <th scope="col" class="rounded-tl-lg pl-4 table-header sm:pl-3 dark:text-white">First Name</th>
                <th scope="col" class="table-header !pl-0 dark:text-white">Last Name</th>
                <th scope="col" class="table-header dark:text-white">Email</th>
                <th scope="col" class="table-header dark:text-white">Phone Number</th>
                <th scope="col" class="table-header dark:text-white">Date Created</th>
                <th scope="col" class="table-header dark:text-white">Date Updated</th>
                <th scope="col" class="rounded-tr-lg py-3.5 pl-3 pr-4 sm:pr-0">
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
      <button id="prevButton" class="pagination-buttons bg-gray-200 text-gray-700 hover:bg-gray-300">
        ← Previous
      </button>
      <button id="nextButton" class="pagination-buttons bg-blue-600 text-white hover:bg-blue-700">
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
          <label for="edit-first-name" class="edit-label dark:text-gray-300">First Name</label>
          <input type="first-name" id="edit-first-name" class="edit-input shadow-md" />
          <span id="error-first-name" class="edit-error"></span>
        </div>
        <div class="mb-4">
          <label for="edit-last-name" class="edit-label dark:text-gray-300">Last Name</label>
          <input type="last-name" id="edit-last-name" class="edit-input shadow-md" />
          <span id="error-last-name" class="edit-error"></span>
        </div>
        <div class="mb-4">
          <label for="edit-email" class="edit-label dark:text-gray-300">Email</label>
          <input type="email" id="edit-email" class="edit-input shadow-md" />
          <span id="error-email" class="edit-error"></span>
        </div>
        <div class="mb-4">
          <label for="edit-phone" class="edit-label dark:text-gray-300">Phone</label>
          <input type="phone" id="edit-phone" class="edit-input shadow-md" />
          <span id="error-phone" class="edit-error"></span>
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

  <div id="add-contact-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Add Contact</h2>
      <form id="add_contact_form">
        <input type="hidden" id="edit-id" />
        <div class="mb-4">
          <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
          <input type="text" id="first_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" name="first_name"/>
          <span id="error-first-name-add" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
        </div>
        <div class="mb-4">
          <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
          <input type="text" id="last_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" name="last_name"/>
          <span id="error-last-name-add" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
          <input type="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" name="email" type="email"/>
          <span id="error-email-add" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
        </div>
        <div class="mb-4">
          <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
          <input type="text" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="tel" maxlength=10 name="phone"/>
          <span id="error-phone-add" class="text-right text-xs text-red-600 min-h-[1rem]"></span>
        </div>
        <div class="flex justify-between">
          <div class="flex space-x-2">
            <button onclick="open_add_contact_form()" type="button" id="cancel-add" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded cursor-pointer">Cancel</button>
            <button id="add_contact" type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded cursor-pointer">Save</button>
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

    // document.getElementById("add-contact").addEventListener("click", function () {
    //   window.location.href = "/contacts/create";
    //   loadContactTable(window.AppState.currentPage);
    // });

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

  function open_add_contact_form()
  {
    if (document.getElementById("add-contact-modal").classList.contains("hidden"))
      document.getElementById("add-contact-modal").classList.remove("hidden"); 
    else
      document.getElementById("add-contact-modal").classList.add("hidden"); 
  }

  document.getElementById("add_contact").addEventListener("click", async (event) => 
  {
      event.preventDefault();

      const formData = new FormData(document.getElementById("add_contact_form"));
      console.log(document.getElementById("add_contact_form"));
      const data = Object.fromEntries(formData.entries());
      console.log(data);
      data.first_name = data.first_name.trim();
      data.last_name = data.last_name.trim();
      data.email = data.email.trim().toLowerCase();

      if(!data.first_name){
        document.getElementById("error-first-name-add").textContent = "Please enter your contact's first name.";
        document.getElementById("error-first-name-add").removeAttribute("hidden");
    }
        
    if(!data.last_name){
        document.getElementById("error-last-name-add").textContent = "Please enter your contact's last name.";
        document.getElementById("error-last-name-add").removeAttribute("hidden");
    }
    if(!data.email){
        document.getElementById("error-email-add").textContent = "Please enter your contact's email.";
        document.getElementById("error-email-add").removeAttribute("hidden");
    }
    if(!data.phone){
        document.getElementById("error-phone-add").textContent = "Please enter your contact's phone.";
        document.getElementById("error-phone-add").removeAttribute("hidden");
    }

    if (!data.first_name || !data.last_name || !data.email || !data.phone) 
        return;

      const body = JSON.stringify(data);

      // console.log(body);

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
