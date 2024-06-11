@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Users list</h4>

    <div class="gap-2">
        <button class="btn btn-outline-primary me-md-2" type="button" id="prev-page-btn">Previous page</button>
        <button class="btn btn-primary" type="button" id="next-page-btn">Next page</button>
    </div>
</div>

<ul class="list-group" id="users-list"></ul>

<script>
    const usersList = document.getElementById('users-list')
    const prevPageBtn = document.getElementById("prev-page-btn")
    const nextPageBtn = document.getElementById("next-page-btn")

    let links = {
        prev_url: null,
        next_url: '/api/v1/users'
    }

    async function getListOfUsers(url) {
        try {
            const res = await fetch(url);
            if (!res.ok) throw new Error(`Failed to fetch: ${res.status}`);
            return await res.json();
        } catch (error) {
            alert(error.message)
            return null;
        }
    }

    function displayUsers(users) {
        usersList.innerHTML = ''

        users.forEach((user) => {
            const usersListItem = `  
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <img class="ms-2 h-full rounded" src="${user.photo}"/>

                
                <div class="ms-5 me-auto">

                    <div class="fw-bold mb-2">${user.name}</div>
                    <span class="badge rounded-pill text-bg-primary">${user.position}</span> 
                    <span class="badge rounded-pill text-bg-primary">${user.email}</span> 
                    <span class="badge rounded-pill text-bg-primary">${user.phone}</span> 
             
                    <p></p>
                </div>
            </li>`

            usersList.innerHTML += usersListItem
        })
    }

    function setupButtonsLinks(urls) {
        links = urls
        if (!links.prev_url) prevPageBtn.disabled = true
        else prevPageBtn.disabled = false

        if (!links.next_url) nextPageBtn.disabled = true
        else nextPageBtn.disabled = false
    }

    (async () => {
        const result = await getListOfUsers(links.next_url);

        prevPageBtn.addEventListener('click', async () => {
            const result = await getListOfUsers(links.prev_url)
            setupButtonsLinks(result.links)
            displayUsers(result.users)
        })

        nextPageBtn.addEventListener('click', async () => {
            const result = await getListOfUsers(links.next_url)
            setupButtonsLinks(result.links)
            displayUsers(result.users)
        })

        setupButtonsLinks(result.links)
        displayUsers(result.users)


    })()
</script>

@endsection