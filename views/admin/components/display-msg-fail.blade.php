@if (isset($_SESSION['status']) && !$_SESSION['status'])
    <div class="alert alert-danger">
        {{ $_SESSION['msg'] }}
    </div>

    @php
        unset($_SESSION['status']);
        unset($_SESSION['msg']);
    @endphp
@endif