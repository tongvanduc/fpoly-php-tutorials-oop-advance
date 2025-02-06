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
    @include('admin.components.display-errors')

    <div class="row">
        <div class="col-12 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <form action="/admin/products/update/{{ $product['p_id'] }}" method="POST"
                            enctype="multipart/form-data">
                            <div class="mb-3 row">
                                <label for="name" class="col-4 col-form-label">Name</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ $product['p_name'] }}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="category_id" class="col-4 col-form-label">Category</label>
                                <div class="col-8">
                                    <select class="form-select" name="category_id" id="category_id">
                                        <option selected>Chọn danh mục</option>
                                        @foreach ($categories as $category)
                                            <option @selected($category['id'] == $product['p_category_id']) value="{{ $category['id'] }}">
                                                {{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="overview" class="col-4 col-form-label">Overview</label>
                                <div class="col-8">
                                    <textarea class="form-control" id="overview" name="overview">{{ $product['p_overview'] }}</textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="content" class="col-4 col-form-label">Content</label>
                                <div class="col-8">
                                    <textarea id="content" name="content">{!! $product['p_content'] !!}</textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="img_thumbnail" class="col-4 col-form-label">Img thumbnail</label>
                                <div class="col-8">
                                    <input type="file" class="form-control" name="img_thumbnail" id="img_thumbnail" />

                                    <img src="{{ file_url($product['p_img_thumbnail']) }}" width="100px" alt="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="price" class="col-4 col-form-label">Price</label>
                                <div class="col-8">
                                    <input type="number" class="form-control" name="price" id="price"
                                        value="{{ $product['p_price'] }}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="price_sale" class="col-4 col-form-label">Price sale</label>
                                <div class="col-8">
                                    <input type="number" class="form-control" name="price_sale" id="price_sale"
                                        value="{{ $product['p_price_sale'] }}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="is_active" class="col-4 col-form-label">Is Active?</label>
                                <div class="col-8">
                                    <input type="checkbox" class="form-checkbox" @checked($product['p_is_active']) value="1"
                                        name="is_active" id="is_active" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="is_sale" class="col-4 col-form-label">Is Sale?</label>
                                <div class="col-8">
                                    <input type="checkbox" class="form-checkbox" @checked($product['p_is_sale']) value="1"
                                        name="is_sale" id="is_sale" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="is_show_home" class="col-4 col-form-label">Is Show Home?</label>
                                <div class="col-8">
                                    <input type="checkbox" class="form-checkbox" @checked($product['p_is_show_home']) value="1"
                                        name="is_show_home" id="is_show_home" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="offset-sm-4 col-sm-8">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>

                                    <a href="/admin/products" class="btn btn-warning">
                                        Back to list
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('content');
    </script>
@endsection

