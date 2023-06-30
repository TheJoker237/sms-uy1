
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">PV Student</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('student/list') }}">Pv Session Rattrapage</a></li>
                                <li class="breadcrumb-item active">Pv Student Session Rattrapage</li>
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
                            <input type="text" class="form-control" placeholder="Search by Date ...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by Faculte ...">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="btn" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Pv Student Session Rattrapage</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('examen/controle') }}" class="btn btn-outline-gray me-2 active"><i class="feather-list"></i></a>
                                        <a href="{{ route('examen/controle/faculty') }}" class="btn btn-outline-gray me-2"><i class="feather-grid"></i></a>
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                        <a href="{{ route('examen/add') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>Code UE</th>
                                            <th>Intitulé</th>
                                            <th>Crédit</th>
                                            <th>Moy/100</th>
                                            <th>Mention</th>
                                            <th>Semestre</th>
                                            <th>Année</th>
                                            <th>Décision</th>
                                            <th class="text-end">
                                                {{-- Action Just For Style --}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($pvStudent)}} --}}
                                        @for ($i = 0 ; $i < count($pvStudent) ; $i++)
                                            <tr>
                                                {{-- <td hidden class="id">{{ $pv->id }}</td> --}}
                                                <td>{{$pvStudent[$i]->code}}</td>                                              
                                                <td>{{$pvStudent[$i]->title}}</td>                                              
                                                <td>--</td>                                              
                                                <td>{{$pvStudent[$i]->total}}</td>                                              
                                                <td>{{$pvStudent[$i]->mentionShort}}</td>                                              
                                                <td>--</td>                                              
                                                <td>{{date('d-m-Y', strtotime($pvStudent[$i]->year))}}</td>                                              
                                                <td>{{$pvStudent[$i]->dec}}</td>                                              
                                                <td class="text-end">
                                                        {{-- <a href="{{ url('examen/edit/'.$controle->id) }}" class="btn btn-sm bg-danger-light">
                                                            <i class="feather-edit"></i>
                                                        </a> --}}
                                                        {{-- <a class="btn btn-sm bg-danger-light student_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
                                                            <i class="feather-trash-2 me-1"></i>
                                                        </a> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                            {{$i++}}
                                        @endfor
                                    </tbody>
                                </table>
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
                    <form action="{{ route('examen/delete') }}" method="POST">
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
