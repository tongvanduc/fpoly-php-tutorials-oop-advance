@if (!empty($_SESSION['errors']))
    <div class="alert alert-danger">
        <ul>
            @foreach ($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @php
        unset($_SESSION['errors']);
    @endphp
@endif
