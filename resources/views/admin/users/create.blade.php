@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Create Staff Member</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Staff</li>
                </ol>
            </nav>
        </div>
        <a href="{{route('staff')}}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <div class="card p-4">
        <form method="POST" id="create_staff" action="{{ route('store-staff') }}">
            @csrf
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required maxlength="50" placeholder="Enter Name">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required maxlength="50" placeholder="Enter Email">
            </div>
            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select class="form-control" name="role" id="role" required>
                    <option value="" selected disabled>Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{$role->name}}" {{(old('role') == $role->name) ? 'selected' : ''}}>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select class="form-control" name="status" id="status" required>
                    <option value="" selected disabled>Select Status</option>
                    <option value="Active" {{(old('status') == 'Active') ? 'selected' : ''}}>Active</option>
                    <option value="Inactive" {{(old('status') == 'Inactive') ? 'selected' : ''}}>Inactive</option>
                </select>
            </div>
            <div class="col-md-12">
            <button class="btn btn-primary btn-sm mt-3" type="submit">Save</button>
            </div>
        </div>
        </form>
    </div>
@endsection
@section('js')
<script>
    $("#create_staff").validate({
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.addClass("text-danger");
            error.insertAfter(element);
        },
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: "{{ route('check-email') }}",
                    type: "get",
                    data: {
                        email: function() {
                            return $("#email").val();
                        },
                    }
                }
            },
        },
        messages: {
            email: {
                remote: "Email already exist!"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@endsection
