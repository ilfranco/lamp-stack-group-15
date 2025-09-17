function openEditForm(contact) {
    document.getElementById("edit-id").value = contact.id;
    document.getElementById("edit-first-name").value = contact.first_name;
    document.getElementById("edit-last-name").value = contact.last_name;
    document.getElementById("edit-email").value = contact.email;
    document.getElementById("edit-phone").value = contact.phone;
    document.getElementById("edit-modal").classList.remove("hidden");
}

function submitEditForm(contact){
    const xhr = new XMLHttpRequest();
    const url = 'http://localhost/api/contacts/update/index.php';

    let data = {
        id: contact.id,
        first_name: contact.first_name,
        last_name: contact.last_name,
        email: contact.email,
        phone: contact.phone
    };

    if(!data.first_name){
        document.getElementById("error-first-name").textContent = "Please enter your contact's first name.";
        document.getElementById("error-first-name").removeAttribute("hidden");
    }
        
    if(!data.last_name){
        document.getElementById("error-last-name").textContent = "Please enter your contact's last name.";
        document.getElementById("error-last-name").removeAttribute("hidden");
    }
    if(!data.email){
        document.getElementById("error-email").textContent = "Please enter your contact's email.";
        document.getElementById("error-email").removeAttribute("hidden");
    }
    if(!data.phone){
        document.getElementById("error-phone").textContent = "Please enter your contact's phone.";
        document.getElementById("error-email").removeAttribute("hidden");
    }

    if (!data.first_name || !data.last_name || !data.email || !data.phone) 
        return;

    const jsonPayload = JSON.stringify(data);
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            const response = JSON.parse(xhr.responseText);
            
            if (response.success === "true") {
                console.log("Contact updated successfully.");
                document.getElementById("edit-modal").classList.add("hidden");
                loadContactTable();
            }
            else{
                console.log(response.error);
            }
        }
    };

    xhr.send(jsonPayload);
}

function deleteUser(contactId){
    if(!contactId)
        return;

    const xhr = new XMLHttpRequest();
    const url = 'http://localhost/api/contacts/delete/index.php';

    let data = {
        id: contactId
    };

    const jsonPayload = JSON.stringify(data);
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success === "true") {
                document.getElementById("confirm-delete-modal").classList.add("hidden");
                document.getElementById("edit-modal").classList.add("hidden");
                loadContactTable(window.AppState.currentPage); 
            } else {
                console.log("Delete failed: " + response.error);
            }
        }
    };

    xhr.send(jsonPayload);
}