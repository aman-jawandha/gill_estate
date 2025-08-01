@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">FAQs</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home"
                                style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">FAQs</li>
                </ol>
            </nav>
        </div>
        @can('create-faq')
            <a href="{{ route('create-faq') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
        @endcan
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="data_table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>FAQ</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faqs as $key => $faq)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{$key}}" aria-expanded="false"
                                            aria-controls="collapse_{{$key}}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse_{{$key}}" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {!! nl2br(e($faq->answer)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($faq->status == 'Active')
                                <button class="btn btn-success btn-sm">{{ $faq->status }}</button>
                            @else
                                <button class="btn btn-danger btn-sm">{{ $faq->status }}</button>
                            @endif
                        </td>
                        <td>
                            @can('edit-faq')
                                <a href="{{ route('edit-faq', $faq->id) }}" class="btn btn-success btn-sm"><i
                                        class="fa fa-edit"></i></a>
                            @endcan
                            @can('delete-faq')
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete('{{ route('delete-faq', $faq->id) }}', 'FAQ')"><i
                                        class="fa fa-trash"></i></button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('js')
@endsection
