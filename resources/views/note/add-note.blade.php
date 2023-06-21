
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Add Examens</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('examen/add') }}">Examen</a></li>
                                <li class="breadcrumb-item active">Add Examen</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <form action="{{ route('note/save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- <input type="hidden" class="form-control" name="id" value="{{ $examen->id }}" readonly> --}}
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Examen Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Faculté <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('faculty') is-invalid @enderror" name="faculte">
                                                <option selected disabled>Select Faculty</option>
                                                @foreach($faculteList as $faculte)
                                                <option value="{{$faculte->title}}">{{$faculte->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('faculty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Filière <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('filiere') is-invalid @enderror" name="faculte">
                                                <option selected disabled>Select Filiere</option>
                                                @foreach($filiereList as $filiere)
                                                <option value="{{$filiere->title}}">{{$filiere->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('filiere')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Course <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('course') is-invalid @enderror" name="course">
                                                <option selected disabled>Select Course</option>
                                                @foreach($courseList as $course)
                                                <option value="{{$course->title}}">{{$course->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('course')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Type <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('type') is-invalid @enderror" name="type">
                                                <option selected disabled>Select Type</option>
                                                <option value="Controle Continue" >Controle Continue</option>
                                                <option value="Session Normale" >Session Normale</option>
                                            </select>
                                            @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Session <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('session') is-invalid @enderror" name="session">
                                                <option selected disabled>Select Session</option>
                                                <option value="Normale">Normale</option>
                                                <option value="Rattrapage" >Rattrapage</option>
                                            </select>
                                            @error('session')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Student <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('session') is-invalid @enderror" name="session">
                                                <option selected disabled>Select Student</option>
                                                <option value=""></option>
                                                
                                            </select>
                                            @error('session')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Note </label>
                                            <input class="form-control @error('phone_number') is-invalid @enderror" type="number"  name="phone_number" placeholder="Enter Note" value="">
                                            @error('phone_number')
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

                                    

                                    {{-- // --}}

                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
