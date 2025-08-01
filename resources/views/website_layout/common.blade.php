@if (session('success'))
    <p class="alert alert-success text-success notify_alert"><b><i class="fa fa-check-circle"></i>
            {{ session('success') }}</b></p>
@endif
@if (session('error'))
    <p class="alert alert-danger text-danger notify_alert"><b><i class="fa fa-exclamation-circle"></i>
            {{ session('error') }}</b></p>
@endif
