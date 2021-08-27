<table class="table table-condensed table-hover">
    <tbody>
        <tr>
            <td>Name:</td>
            <td>{{$bundle->name}}</td>
        </tr>
        <tr>
            <td>Price:</td>
            <td>{{$bundle->price}}</td>
        </tr>
        <tr>
            <td>Number of items in bundle:</td>
            <td>{{$bundle->products->count()}}</td>
        </tr>
        <tr>
            <td>Description:</td>
            <td>{{$bundle->description}}</td>
        </tr>
    </tbody>
</table>
