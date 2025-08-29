<?php
    /* ------------------------------------
    THESE ARE THE AUTH API ENDPOINTS:

        1. /api/auth/login
            - POST request (method)
            - JSON Payload:
            {
                email: email@example.com
                password: password123
            }
            - This endpoint authenticates a user.
            - This endpoint should respond with some kind of auth token to validate future user requests.

        2. /api/auth/register
            - POST request
            - JSON Payload:
            {
                first_name: John
                last_name: Doe
                email: email@example.com
                password: password123
            }
            - This endpoint should create a new row in the users table using the key/value pairs from the JSON Payload.

    ------------------------------------ */

    /*
    THESE ARE THE CONTACTS API ENDPOINTS:
        1. /api/contacts
            - GET request
            - This endpoint should first validate the user's auth token and then respond with every row in the contacts table that has matching user_id.

        2. /api/contacts/create
            - POST request
            - JSON Payload:
            {
                first_name: Jane (NOT NULL)
                last_name: Joe (NOT NULL)
                email: email@example.com
                phone: 0123456789
            }
            - This endpoint should first validate the user's auth token and then create a new row in the contacts table using the key/value pairs from the JSON Payload, as well as the current users id for the user_id column.

        3. /api/contacts/read/{contact-id}
            - GET request
            - This endpoint should first validate the user's auth token and then respond with the row in the contacts table that has the matching user_id.

        4. /api/contacts/update/{contact-id}
            - PATCH request
            - JSON Payload:
            {
                first_name: Jane (NOT NULL)
                last_name: Joe (NOT NULL)
                email: email@example.com
                phone: 0123456789
            }
            - This endpoint should first validate the user's auth token and then update the row in the contacts table that corresponds with the given contact-id.

        5. /api/contacts/delete/{contacts-id}
            - DELETE request 
            - This endpoint should first validate the user's auth token, verify the contact belongs to the user via something like `id === contact_id.user_id`, and then delete the row.

        6. /api/contacts?search_by=column_name&search_for=term
            - GET request
            - This endpoint should first validate the user's auth token, then respond with all the rows that match the term under the column_name column THAT ALSO has an user_id value that matches the signed in user's ID. 
    */



    // We want to work with just the path and nothing extra.
    // Example: www.group-15s-pcm.com/api/contacts/create/ becomes /api/contacts/create/
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Remove the slash from end of uri. This is a quality of life thing. 
    // Example: /api/contacts/create/ becomes /api/contacts/create
    if ($uri != '/api/' && $uri != '/api') {
        $uri = rtrim($uri, '/');
    }
    
    // If path starts with /api, then great! We'll only need the rest of the path from here on.
    // But, if not, then return error code.
    if (str_starts_with($uri, '/api')) { 
        $uri = substr($uri, 4);
    } else {
        http_response_code(400);
        exit;
    }

    // If the path now starts with /auth, then pass the $uri and the request to the auth/index.php file.
    // If the path now starts with /contacts, then pass the $uri and the request to the contacts/index.php file.
    // Else, return error code.
    if (str_starts_with($uri, '/auth')) { // If 
        $uri = substr($uri, 5);
        require_once __DIR__ . './../auth/index.php';
    } else if (str_starts_with($uri, '/contacts')) {
        $uri = substr($uri, 9);
        require_once __DIR__ . './../contacts/index.php';
    } else {
        http_response_code(404);
    }
    exit;
?>