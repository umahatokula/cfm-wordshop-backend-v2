{!! Form::model($bundle, ['route' => ['bundles.update', $bundle->id], 'method' => 'PUT']) !!}

    @include('bundles.fields')

{!! Form::close() !!}
