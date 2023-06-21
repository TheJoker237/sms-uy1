
@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">List Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">List Users</li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- message --}}
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Users List</h3>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table
                                class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Date Join</th>
                                        <th>Role Name</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key=>$user )
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td hidden class="user_id">{{ $user->id }}</td>
                                        <td hidden class="avatar">{{ $user->avatar }}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle"src="{{Storage::url($user->avatar)}}"alt="{{ $user->first_name}}">
                                                </a>
                                            </h2>
                                        </td>
                                        <td>{{ $user->first_name .' '.$user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->join_date }}</td>
                                        <td>{{ $user->role_name }}</td>
                                        <td>
                                            <div class="edit-delete-btn">
                                                @if ($user->status === 'Active')
                                                <a class="text-success">{{ $user->status }}</a>
                                                @elseif ($user->status === 'Inactive')
                                                <a class="text-warning">{{ $user->status }}</a>
                                                @elseif ($user->status === 'Disable')
                                                <a class="text-danger" >{{ $user->status }}</a>
                                                @else 
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="{{ url('user/edit/'.$user->id) }}"class="btn btn-sm bg-danger-light">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                @if (Session::get('role_name') === 'Super Admin')
                                                <a class="btn btn-sm bg-danger-light user_delete" data-bs-toggle="modal" data-bs-target="#deleteUser">
                                                    <i class="feather-trash-2 me-1"></i>
                                                </a>
                                                @endif
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
        </div>
    </div>
</div>

{{-- model user delete --}}
<div class="modal fade contentmodal" id="deleteUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header pb-0 border-bottom-0  justify-content-end">
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                    class="feather-x-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user/delete') }}" method="POST">
                    @csrf
                    <div class="delete-wrap text-center">
                        <div class="del-icon">
                            <i class="feather-x-circle"></i>
                        </div>
                        <input type="hidden" name="user_id" class="e_user_id" value="">
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
    $(document).on('click','.user_delete',function()
    {
        var _this = $(this).parents('tr');
        $('.e_user_id').val(_this.find('.user_id').text());
        $('.e_avatar').val(_this.find('.avatar').text());
    });
</script>
@endsection

@endsection
