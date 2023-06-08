
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Courses</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('course/list') }}">Course</a></li>
                                <li class="breadcrumb-item active">All Courses</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by Faculty ...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by Title ...">
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by Phone ...">
                        </div>
                    </div> --}}
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="btn" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-7">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Filiere List</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('student/list') }}" class="btn btn-outline-gray me-2 active"><i class="feather-list"></i></a>
                                        <a href="{{ route('student/grid') }}" class="btn btn-outline-gray me-2"><i class="feather-grid"></i></a>
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                        {{-- <a href="{{ route('student/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a> --}}
                                    </div>
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
                                            <th>Faculty</th>
                                            <th>Title</th>
                                            {{-- <th>DOB</th>
                                            <th>Parent Name</th>
                                            <th>Mobile Number</th>
                                            <th>Address</th> --}}
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($FiliereList as $key=>$list )
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td>FL{{ ++$key }}</td>
                                            <td hidden class="id">{{ $list->id }}</td>
                                            {{-- <td hidden class="avatar">{{ $list->upload }}</td> --}}
                                            {{-- <td>
                                                <h2 class="table-avatar">
                                                    <a href="student-details.html"class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ Storage::url('student-photos/'.$list->upload) }}" alt="User Image">
                                                    </a>
                                                    <a href="student-details.html">{{ $list->first_name }} {{ $list->last_name }}</a>
                                                </h2>
                                            </td> --}}
                                            <td>{{ $list->faculty}}</td>
                                            <td>{{ $list->title}}</td>
                                            {{-- <td>Soeng Soeng</td> --}}
                                            {{-- <td>{{ $list->phone_number }}</td> --}}
                                            {{-- <td>110 Sen Sok Steet,PP</td> --}}
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="{{ url('filiere/edit/'.$list->id) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light student_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
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
                            <form action="{{ route('filiere/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{ $Filiere->id }}" readonly>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Filiere Update
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="{{ route('filiere/list') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <label>Faculty <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('faculty') is-invalid @enderror" name="faculty">
                                                <option selected disabled>Select Faculty</option>
                                                <option value="Faculty Of Sciences" {{ $Filiere->faculty == 'Faculty Of Sciences' ? "selected" :"Faculty of Letters"}}>Faculty Of Sciences</option>
                                                <option value="Faculty of Letters" {{ $Filiere->faculty == 'Faculty of Letters' ? "selected" :""}}>Faculty of Letters</option>
                                                <option value="Others" {{ $Filiere->faculty == 'Others' ? "selected" :""}}>Others</option>
                                            </select>
                                            @error('faculty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group local-forms">
                                            <label>Title Filiere <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Enter Title Filiere" value="{{ $Filiere->title }}">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
                    <form action="{{ route('filiere/delete') }}" method="POST">
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
        $(document).on('click','.student_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>
    @endsection

@endsection