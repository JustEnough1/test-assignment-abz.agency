@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Register New User</h4>

</div>

<form>
    <div class="input-group mb-3">
        <button class="btn btn-outline-secondary" type="button" id="button-addon2">Get token</button>
        <input type="text" class="form-control" placeholder="Token" aria-label="token" name="token">
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Full Name" aria-label="name" name="name">
    </div>

    <div class="row">
        <div class="col-6">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="emial" class="form-control" placeholder="Email" aria-label="email" name="email">
            </div>
        </div>
        <div class="col-6">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">+380</span>
                <input type="tel" pattern="[0-9]{3}-[0-9]{3}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" placeholder="Phone" aria-label="phone" name="phone">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <label for="position" class="form-label">Select position</label>
            <select class="form-select" aria-label="position" name="position">
                <option selected>Position</option>
            </select>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="photo" class="form-label">Select Photo</label>
                <input class="form-control" type="file" id="photo" name="photo" placeholder="photo">

            </div>
        </div>
    </div>
    <input class="btn btn-primary" type="submit" value="Submit">

</form>
@endsection