@extends('layouts.app', ['title' => 'Home'])

<div id="loader" class="d-none position-absolute left-0 top-0 opacity-75 bg-dark z-3 w-100 h-100 d-flex justify-content-center align-items-center">
    <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

@section('content')



<div class="d-flex justify-content-between mb-3">
    <h4>Register New User</h4>
</div>

<form method="POST" id="user-form">
    <div class="input-group mb-3">
        <button class="btn btn-outline-secondary" type="button" id="get-token-btn">Get token</button>
        <input type="text" class="form-control" placeholder="No token" aria-label="token" id="token" name="token" disabled>
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Full Name" aria-label="name" name="name" id="name" required>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="emial" class="form-control" placeholder="Email" aria-label="email" name="email" id="email" required>
            </div>
        </div>
        <div class="col-6">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">+380</span>
                <input maxlength="9" type='text' class="form-control" placeholder="Phone" aria-label="phone" name="phone" id="phone" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <label for="position" class="form-label">Select Position</label>
            <select class="form-select" aria-label="position" name="position" id="position" required>
            </select>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="photo" class="form-label">Select Photo</label>
                <input class="form-control" type="file" id="photo" name="photo" placeholder="photo" required>

            </div>
        </div>
    </div>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>

<div class="alert alert-danger mt-5 d-none" id="fails" role="alert">

</div>

<div class="toast-container position-absolute bottom-0 end-0 p-2">
    <div class="toast" id="user-created-toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <h5>New user created!</h5>
            <ul id="user-created-body"></ul>
        </div>
    </div>
</div>

<script>
    const loader = document.getElementById('loader');
    const getTokenBtn = document.getElementById('get-token-btn');
    const positionSelector = document.getElementById('position');
    const userForm = document.getElementById('user-form');

    // Fetch positions
    fetch('/api/v1/positions').then(response => {
        response.json().then(data => {
            data.positions.forEach(position => {
                positionSelector.innerHTML += ` <option value=${position.id}>${position.name}</option>`
            });
        })
    })

    // Get token
    getTokenBtn.addEventListener('click', async () => {
        loader.classList.remove('d-none')
        try {

            const response = await fetch('/api/v1/token');
            if (!response.ok) throw new Error(`Failed to fetch: ${res.status}`);

            const result = await response.json();

            document.getElementById('token').value = result.token;
        } catch (error) {
            alert(error)
        }
        loader.classList.add('d-none')
    })

    // Create user
    function createFormData() {
        const photo = document.getElementById('photo').files[0];
        const formData = new FormData();

        formData.append('name', document.getElementById('name').value)
        formData.append('email', document.getElementById('email').value)
        formData.append('phone', '+380' + document.getElementById('phone').value)
        formData.append('position_id', document.getElementById('position').value)
        formData.append('photo', photo)

        return formData
    }

    function createHeaders() {
        const token = document.getElementById('token').value;

        const headers = new Headers()
        headers.append('Authorization', `Bearer ${token}`)

        return headers
    }

    async function postUser() {

        const headers = createHeaders()
        const formData = createFormData()

        const response = await fetch('/api/v1/users', {
            method: "POST",
            headers,
            body: formData,
        });

        const result = await response.json();

        if (!response.ok) {
            if (result.fails) displayFails(result.fails)
        }

        return result;
    }

    // Display created user
    function displayFails(fails) {
        document.getElementById('fails').classList.remove('d-none')
        document.getElementById('fails').innerText = ''
        Object.values(fails).map((message) => {
            document.getElementById('fails').innerText += message + '\n'
        })
    }

    async function getUser(id) {
        const response = await fetch('/api/v1/users/' + id)
        const result = await response.json()
        return result.user
    }

    function createToast(user) {
        document.getElementById('user-created-body').innerHTML = ''
        document.getElementById('user-created-toast').classList.add('show')
        Object.entries(user).map(([key, value]) => {
            document.getElementById('user-created-body').innerHTML += `<li>${key} - ${value}</li>`
        })
    }

    userForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        document.getElementById('fails').classList.add('d-none')
        loader.classList.remove('d-none')
        const result = await postUser()

        if (!result.success) {
            loader.classList.add('d-none')
            return alert(result.message)
        }

        const user = await getUser(result.user_id)
        loader.classList.add('d-none')

        if (user) createToast(user)
        clearFails()
    })
</script>
@endsection