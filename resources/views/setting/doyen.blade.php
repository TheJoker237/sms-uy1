@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Settings</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('setting/page') }}">Settings</a></li>
                            <li class="breadcrumb-item active">Doyen</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="settings-menu-links">
                <ul class="nav nav-tabs menu-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('setting/page') }}">General Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('setting/page/academicYear') }}">Academic Year</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('setting/doyen')}}">Doyen Settings</a>
                    </li>
                </ul>
            </div>

            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-7">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Doyen </h3>
                                    </div>
                                    {{-- <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('student/list') }}" class="btn btn-outline-gray me-2 active"><i class="feather-list"></i></a>
                                        <a href="{{ route('student/grid') }}" class="btn btn-outline-gray me-2"><i class="feather-grid"></i></a>
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                        <a href="{{ route('student/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Grade</th>
                                            {{-- <th>DOB</th>
                                            <th>Parent Name</th>
                                            <th>Mobile Number</th>
                                            <th>Address</th> --}}
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($doyens as $key=>$doyen )
                                        <tr class="doyen-set">
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td>DY{{ ++$key }}</td>
                                            <td hidden class="id">{{ $doyen->id }}</td>
                                            <td hidden class="id-teacher">{{ $doyen->teacher->id }}</td>
                                            <td hidden class="avatar">{{ $doyen->teacher->user->avatar }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="student-details.html"class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ Storage::url($doyen->teacher->user->avatar) }}" alt="User Image">
                                                    </a>
                                                    <a class="doyen" href="student-details.html">{{ $doyen->teacher->title.' '.$doyen->teacher->user->first_name.' '.$doyen->teacher->user->last_name}}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $doyen->teacher->grade }}</td>
                                            {{-- <td>Soeng Soeng</td> --}}
                                            {{-- <td>{{ $doyen->phone_number }}</td> --}}
                                            {{-- <td>110 Sen Sok Steet,PP</td> --}}
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="#" class="btn btn-sm bg-danger-light doyen-edit">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light doyen_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
                                                        <i class="feather-trash-2 me-1"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <form id="doyen-form" action="{{ route('setting/doyen/set') }}" method="POST" enctype="application/x-www-form-urlencoded">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="" readonly>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title">
                                            <span class="doyen-info">
                                                Doyen Set
                                            </span>
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                                    
                                    <div class="col-8 col-sm-8">
                                        <div class="form-group local-forms">
                                            <label>Teachers <span class="login-danger">*</span></label>
                                            <select class="doyen-field form-control @error('faculty') is-invalid @enderror" name="new_id">
                                                <option selected disabled>Select Doyen</option>
                                                @foreach($teachers as $teacher)
                                                <option hidden value=""></option>
                                                <option value="{{$teacher->id}}">{{ $teacher->title.' '.$teacher->user->first_name.' '.$teacher->user->last_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('faculty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary doyen-submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- model student delete --}}
    <div class="modal fade contentmodal" id="studentUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header pb-0 border-bottom-0  justify-content-end">
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('setting/doyen/unset') }}" method="POST">
                        @csrf
                        <div class="delete-wrap text-center">
                            <div class="del-icon">
                                <i class="feather-x-circle"></i>
                            </div>
                            <input type="hidden" name="id" class="e_id" value="">
                            <input type="hidden" name="avatar" class="e_avatar" value="">
                            <h2>Sure you want to delete</h2>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-success me-2">Yes</button>
                                <a class="btn btn-danger" data-bs-dismiss="modal">No</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')

    {{-- delete js --}}
    <script>
        $(document).on('click','.doyen_delete',function()
        {
            var _this = $(this).parents('tr');
            console.log('ok');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>
    @endsection

    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="row">
        
    </div>
@endsection