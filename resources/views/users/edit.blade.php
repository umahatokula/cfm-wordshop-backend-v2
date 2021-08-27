{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}

    @include('users.fields')

{!! Form::close() !!}
