@extends('admin.layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>
    <h1 class="h2">{{ $title }}</h1>

    <div class="row">
        <div class="col-12 mb-4 mb-lg-0">
            <div class="card">
                <a href="/admin/users/create" class="btn btn-sm btn-success">Create</a>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Trường dữ liệu</th>
                                    <th scope="col">Giá trị</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $field => $value)
                                    <tr>
                                        <td>{{ strtoupper($field) }}</td>
                                        <td>
                                            @switch($field)
                                                @case('avatar')
                                                    <img src="{{ file_url($user['avatar']) }}" width="100px" alt="">
                                                @break

                                                @case('type')
                                                    @if ($user['type'] == 'admin')
                                                        <span class="badge bg-danger">Admin</span>
                                                    @else
                                                        <span class="badge bg-info">Client</span>
                                                    @endif
                                                @break

                                                @case('password')
                                                    ************************
                                                @break

                                                @default
                                                    {{ $value }}
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a href="/admin/users" class="btn btn-warning">
                            Back to list
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
