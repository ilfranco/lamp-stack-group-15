let curPage = 0;
let pageSize = 5;
let length = 0;

document.getElementById("nextButton").addEventListener("click", () => nextPage());
document.getElementById("prevButton").addEventListener("click", () => prevPage());

function prevPage()
{
    if (curPage > 0) {
        curPage--;
        loadContactTable(curPage);
        updatePaginationButtons();
    }
}

function nextPage()
{
    if ((curPage * pageSize) < length /*curPage + 1 < Math.ceil(length/pageSize)*/) {
        curPage++;
        loadContactTable(curPage);
        updatePaginationButtons();
    }
}

function updatePaginationButtons() {
    const prevButton = document.getElementById("prevButton");
    //document.getElementById("nextButton").disabled = curPage + 1 >= getTotalPages();

   prevButton.classList.toggle("hidden", curPage === 0);
}

function formatPhoneNumber(number) {
  const cleaned = ('' + number).replace(/\D/g, '');

  const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
  if (match) {
    return `${match[1]}-${match[2]}-${match[3]}`;
  }

  return number;
}

function loadContactTable(page){

    const xhr = new XMLHttpRequest();
    const url = 'http://localhost/api/contacts/read/get_page.php'; 

    if (page < 0) page = 0;
    //if (page > (length/pageSize)) page = length/pageSize;

    console.log(page);

    let data = {
      page_index: page,
      contacts_per_page: pageSize,
      user_id: "1"
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
            length = response.results.length;
            console.log(length);

            let tableBody = '';
            for(let i = 0; i < response.results.length; i++){
                const contact = response.results[i];
                tableBody += '<tr>';
                tableBody += '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0 dark:text-white">' + contact.first_name + '</td>';
                tableBody += '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0 dark:text-white">' + contact.last_name + '</td>';
                tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + contact.email + '</td>';
                tableBody += '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">' + formatPhoneNumber(contact.phone) + '</td>';
                tableBody += '<td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">';
                tableBody += '<a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit<span class="sr-only">,' + contact.first_name + ' ' + contact.last_name + '</span></a>';
                tableBody += '</td>'
                tableBody += '</tr>';
            }
            
            document.getElementById("tbody").innerHTML = tableBody;
        }
    };

    xhr.send(jsonPayload);
}

