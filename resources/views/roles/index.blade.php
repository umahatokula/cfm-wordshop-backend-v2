@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <!-- Page Heading Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>System Roles</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td scope="row">{{$loop->iteration}}</td>
                        <td>{{$role->name}}</td>
                        <td>
                            @foreach($role->permissions as $permission)
                            {{$permission->name}} <br>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
