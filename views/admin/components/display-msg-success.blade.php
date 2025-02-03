@if (!empty($_SESSION['status']) && $_SESSION['status'])
    <div class="alert alert-success">
        {{ $_SESSION['msg'] }}
    </div>

    @php
        unset($_SESSION['status']);
        unset($_SESSION['msg']);
    @endphp
@endif