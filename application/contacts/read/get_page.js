//let curPage = 0;
let pageSize = 5;
let totalPages;

document.getElementById("nextButton").addEventListener("click", () => nextPage());
document.getElementById("prevButton").addEventListener("click", () => prevPage());



function formatPhoneNumber(number) {
  const cleaned = ('' + number).replace(/\D/g, '');

  const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
  if (match) {
    return `${match[1]}-${match[2]}-${match[3]}`;
  }

  return number;
}

function loadContactTable(){

    const xhr = new XMLHttpRequest();
    const url = 'http://localhost/api/contacts/read/get_page.php'; 

    if (window.AppState.currentPage < 0) window.AppState.currentPage = 0;

    let data = {
      page_index: window.AppState.currentPage,
      contacts_per_page: pageSize,
      user_id: "21"
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
            
            totalPages = Number(response.total_pages);
            
            //Workaround for when the value is 0
            if(totalPages === 0)
                totalPages = 1;

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
                tableBody += '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0 dark:text-white">' + contact.first_name + '</td>';
                tableBody += '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0 dark:text-white">' + contact.last_name + '</td>';
                tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + contact.email + '</td>';
                tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + formatPhoneNumber(contact.phone) + '</td>';
                tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + contact.created_at + '</td>';
                tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + contact.updated_at + '</td>';
                tableBody += '<td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">';
                tableBody += '<a href="#" class="edit-btn text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" data-id="' + contact.id + '">Edit<span class="sr-only">' + contact.first_name + contact.last_name + '</span></a>';
                tableBody += '</td>'
                tableBody += '</tr>';
            }

            if(response.results.length == 0){
                tableBody += '<tr>';
                tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">No contacts available</td>';
                tableBody += '</tr>';
            }
            
            document.getElementById("tbody").innerHTML = tableBody;
        }
    };

    xhr.send(jsonPayload);
}

function prevPage()
{
    let page = window.AppState.currentPage;
    if (page > 0) {
        window.AppState.currentPage--;
        loadContactTable();
        updatePaginationButtons();
    }
}

function nextPage()
{
    let page = window.AppState.currentPage;
    if (page + 1 < totalPages) {
        window.AppState.currentPage++;
        loadContactTable();
        updatePaginationButtons();
    }
}

function updatePaginationButtons() {
   const prevButton = document.getElementById("prevButton");
   const nextButton = document.getElementById("nextButton");

   let page = window.AppState.currentPage;

   prevButton.classList.toggle("hidden", page === 0);
   nextButton.classList.toggle("hidden", (page+1) === totalPages);
}