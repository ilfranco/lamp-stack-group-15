let pageSize = 6;
let totalPages;
let totalPagesSearch;

document.getElementById("nextButton").addEventListener("click", () => nextPage());
document.getElementById("prevButton").addEventListener("click", () => prevPage());

function loadContactTable(){

    const xhr = new XMLHttpRequest();
    const url = '/api/contacts/read/get_page.php'; 

    if (window.AppState.currentPage < 0) window.AppState.currentPage = 0;

    let data = {
      page_index: window.AppState.currentPage,
      contacts_per_page: pageSize,
    };
    
    const jsonPayload = JSON.stringify(data);
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            const response = JSON.parse(xhr.responseText);
            if (response.error) {
                console.log(response.error);
            }

            renderContactTable(response);
        }
    };

    xhr.send(jsonPayload);
}

function searchContacts(query){

    window.AppState.isSearching = true;
    window.AppState.searchQuery = query;

    const xhr = new XMLHttpRequest();
    const url = '/api/contacts/read/search.php'; 

    let data = {
      page_index: window.AppState.currentPage,
      contacts_per_page: pageSize,
      search_term: query
    };

    const jsonPayload = JSON.stringify(data);
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            const response = JSON.parse(xhr.responseText);
            
            if (response.error === "") {
                console.log("Contact searched successfully.");
                renderContactTable(response);
            }
            else{
                console.log(response.error);
            }
        }
    };

    xhr.send(jsonPayload);
}

function renderContactTable(response){
    
    if(window.AppState.isSearching){
        totalPagesSearch = Number(response.total_pages);
    }
    else{
        totalPages = Number(response.total_pages);
    }

    updatePaginationButtons();

    let tableBody = '';
    for(let i = 0; i < response.results.length; i++){
        const contact = response.results[i];
        tableBody += '<tr ' +
            'data-id="' + contact.id + '" ' +
            'data-first-name="' + contact.first_name + '" ' +
            'data-last-name="' + contact.last_name + '" ' +
            'data-email="' + contact.email + '" ' +
            'data-phone="' + contact.phone + '">';
        tableBody += '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3 dark:text-white">' + contact.first_name + '</td>';
        tableBody += '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0 dark:text-white">' + contact.last_name + '</td>';
        tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + contact.email + '</td>';
        tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + formatPhoneNumber(contact.phone) + '</td>';
        tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + contact.created_at + '</td>';
        tableBody += '<td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500 dark:text-gray-400">' + contact.updated_at + '</td>';
        tableBody += '<td class="whitespace-nowrap py-4 pl-0 pr-4 text-align:left text-sm font-medium sm:pr-0">';
        tableBody += '<a href="#" class="edit-btn text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" data-id="' + contact.id + '">Edit<span class="sr-only">' + contact.first_name + contact.last_name + '</span></a>';
        tableBody += '</td>'
        tableBody += '</tr>';
    
    }

    if(response.results.length === 0){
        tableBody += '<tr>';
        tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">No contacts available</td>';
        tableBody += '</tr>';
    }

    document.getElementById("tbody").innerHTML = tableBody;

}

function prevPage()
{
    let page = window.AppState.currentPage;
    if (page > 0) {
        window.AppState.currentPage--;

        if (window.AppState.isSearching) {
            searchContacts(window.AppState.searchQuery);
        } else {
            loadContactTable();
        }

      updatePaginationButtons();
    }
}

function nextPage()
{
    let page = window.AppState.currentPage;

    if (window.AppState.isSearching) {
        if (page + 1 < totalPagesSearch) {
            window.AppState.currentPage++;
            console.log(window.AppState.currentPage);
            searchContacts(window.AppState.searchQuery);
        }
    } else {
        if (page + 1 < totalPages) {
            window.AppState.currentPage++;
            loadContactTable();
        }
    }

    console.log(window.AppState.isSearching);
    updatePaginationButtons();
}

function updatePaginationButtons() {
   const prevButton = document.getElementById("prevButton");
   const nextButton = document.getElementById("nextButton");
   const pageIndicator = document.getElementById("page-indicator");

   let page = window.AppState.currentPage;
   let total;

   if(window.AppState.isSearching)
        total = totalPagesSearch;
   else
        total = totalPages;

   prevButton.classList.toggle("hidden", page === 0);
   nextButton.classList.toggle("hidden", (page+1) >= total);

   if(total === 0)
        pageIndicator.textContent = 'Page ' + page +' of ' + total;
   else
        pageIndicator.textContent = 'Page ' + (page+1) +' of ' + total;
}

function formatPhoneNumber(number) {
  const cleaned = ('' + number).replace(/\D/g, '');

  const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
  if (match) {
    return `${match[1]}-${match[2]}-${match[3]}`;
  }

  return number;
}