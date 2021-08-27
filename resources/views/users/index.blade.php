@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>System Users</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="box">
            <div class="box-body">
                        
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                <ul class="nav nav-tabs nav-fill mb-15">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i
                                class="zmdi zmdi-accounts"></i> System Users</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#create"><i
                                class="zmdi zmdi-account-add"></i> Create New User</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="list">
                        <p>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>User</th>
                                        <th>Role(s)</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                {{$role->name}} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">

                                            <a data-href="#" data-clipboard-text="zmdi zmdi-edit"  data-toggle="modal" data-target="#modal" data-remote="{{route('users.show', $user->id)}}"><i class="text-info zmdi zmdi-eye zmdi-hc-fw"></i></a>

                                            <a data-href="#" data-clipboard-text="zmdi zmdi-edit"  data-toggle="modal" data-target="#modal" data-remote="{{route('users.edit', $user->id)}}"><i class="text-primary zmdi zmdi-edit zmdi-hc-fw"></i></a>
                                            
                                            <a data-href="{{route('users.delete', $user->id)}}" data-clipboard-text="zmdi zmdi-delete" data-toggle="modal" data-target="#confirmationModal"><i class="text-danger zmdi zmdi-delete zmdi-hc-fw"></i></a>

                                       </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </p>
                    </div>
                    <div class="tab-pane fade" id="create">

                        <p>
                            {!! Form::open(['route' => 'users.store']) !!}

                            @include('users.fields')

                            {!! Form::close() !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
