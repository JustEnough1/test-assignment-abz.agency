@extends('layouts.app', ['title' => 'Home'])

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Users list</h4>
    </div>

    @if (!$data->success)
        <h2>{{ $data->message }}</h2>
    @else
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href={{ $data->links->prev_url }}>Previous</a></li>
                @php
                    $paginationStart = floor(($data->page - 1) / 5) * 5 + 1;
                @endphp
                @for ($i = $paginationStart; $i < $paginationStart + 5; $i++)
                    @if ($data->total_pages < $i)
                    @break
                @endif
                <li class="page-item {{ $data->page == $i ? 'active' : '' }}"><a class="page-link"
                        href="/users?page={{ $i }}">{{ $i }}</a></li>
            @endfor
            <li class="page-item"><a class="page-link" href={{ $data->links->next_url }}>Next</a></li>
        </ul>
    </nav>
    <ul class="list-group" id="users-list">
        @foreach ($data->users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <img class="ms-2 h-full rounded" src={{ $user->photo }} />
                <div class="ms-5 me-auto">
                    <div class="fw-bold mb-2">{{ $user->name }}</div>
                    <span class="badge rounded-pill text-bg-primary">{{ $user->position }}</span>
                    <span class="badge rounded-pill text-bg-primary">{{ $user->email }}</span>
                    <span class="badge rounded-pill text-bg-primary">{{ $user->phone }}</span>
                </div>
            </li>
        @endforeach
    </ul>
@endif
@endsection
