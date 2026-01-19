@extends('admin_layout.app')
@section('content')
    <div class="d-flex align-items-center content-space-between pt-2 pb-4">
        <div style="width:95%">
            <h3 class="fw-bold">Days Breaks</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-home" style="color: #947054"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Availability
                    </li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary btn-sm m-1" onclick="$('#days_break_modal').modal('show');"><i class="fa fa-plus"></i></button>
        <a href="{{route('availability')}}" class="btn btn-primary btn-sm m-1">Back</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="data_table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($days_breaks as $key => $break)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ changeDateFormat($break->from_date) }}</td>
                        <td>{{ changeDateFormat($break->to_date) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-days-break', $break->id) }}', 'Days Break')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<div class="modal fade" id="days_break_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Days Breaks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#days_break_modal').modal('hide');">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('store-days-break')}}" method="post">
        @csrf
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <label class="form-lable">From Date</label>
                <input type="date" class="form-control" name="from_date" required min="{{date('Y-m-d')}}">
            </div>
            <div class="col-md-6">
                <label class="form-lable">To Date</label>
                <input type="date" class="form-control" name="to_date" required min="{{date('Y-m-d')}}">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
    
@endsection
