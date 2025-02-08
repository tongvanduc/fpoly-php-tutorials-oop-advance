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

    @include('admin.components.display-msg-fail')
    @include('admin.components.display-msg-success')

    <div class="row">
        <div class="col-12 mb-4 mb-lg-0">
            <div class="card">
                <a href="/admin/products/create" class="btn btn-sm btn-success">Create</a>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Img Thumbnail</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Price Sale</th>
                                    <th scope="col">Is Sale?</th>
                                    <th scope="col">Is Show Home?</th>
                                    <th scope="col">Is Active?</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Updated at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $product)
                                    <tr>
                                        <td scope="row">{{ $product['p_id'] }}</td>
                                        <td>{{ $product['p_name'] }}</td>
                                        <td>{{ $product['c_name'] }}</td>
                                        <td>
                                            <img src="{{ file_url($product['p_img_thumbnail']) }}" width="100px"
                                                alt="">
                                        </td>
                                        <td>{{ number_format($product['p_price']) }}</td>
                                        <td>{{ number_format($product['p_price_sale']) }}</td>
                                        <td>
                                            @if ($product['p_is_sale'])
                                                <span class="badge bg-info">YES</span>
                                            @else
                                                <span class="badge bg-danger">NO</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product['p_is_show_home'])
                                                <span class="badge bg-info">YES</span>
                                            @else
                                                <span class="badge bg-danger">NO</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product['p_is_active'])
                                                <span class="badge bg-info">YES</span>
                                            @else
                                                <span class="badge bg-danger">NO</span>
                                            @endif
                                        </td>
                                        <td>{{ $product['p_created_at'] }}</td>
                                        <td>{{ $product['p_updated_at'] }}</td>
                                        <td>
                                            <a href="/admin/products/show/{{ $product['p_id'] }}"
                                                class="btn btn-sm btn-info">Show</a>
                                            <a href="/admin/products/edit/{{ $product['p_id'] }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <a href="/admin/products/delete/{{ $product['p_id'] }}"
                                                onclick="return confirm('Có chắc chắn xóa không?')"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <nav aria-label="Page navigation" class="d-flex">
                        <ul class="pagination">
                            @for ($i = 1; $i <= $totalPage; ++$i)
                                <li class="page-item @if ($page == $i) active @endif">
                                    <a class="page-link" href="/admin/products/?page={{ $i }}&limit={{ $limit }}">{{ $i }}</a>
                                </li>
                            @endfor
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
@endsection
