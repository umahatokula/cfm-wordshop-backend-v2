<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($preOrderType->preorders as $preorder)
        <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $preorder->name }}</td>
            <td>{{ $preorder->email }}</td>
        </tr>
        @endforeach
    </tbody>
</table>