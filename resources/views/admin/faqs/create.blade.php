@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Create FAQ</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">FAQs</li>
                </ol>
            </nav>
        </div>
        <a href="{{route('faqs')}}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <div class="card p-4">
        <form method="POST" action="{{ route('store-faq') }}">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <label class="form-label">Question</label>
                <input type="text" class="form-control" name="question" maxlength="250" required placeholder="Question">
            </div>
            <div class="col-md-12">
                <label class="form-label">Answer</label>
                <textarea class="form-control" rows="7" name="answer" required maxlength="2000" placeholder="Write Answer"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select class="form-control" name="status" id="status" required>
                    <option value="" selected disabled>Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-12">
            <button class="btn btn-primary btn-sm mt-3" type="submit">Save</button>
            </div>
        </div>
        </form>
    </div>
@endsection
