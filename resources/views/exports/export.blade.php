<table border="1">
    <thead>
    <tr>
        <th>Pengirim</th>
        <th>Handphone</th>
        <th>Alamat</th>
        <th>Arwah</th>
        <th>Makam</th>
    </tr>
    </thead>
    <tbody>
    @foreach($hauls as $haul)
        @foreach ($haul->arwahs as $item)
            <tr>
                <td>{{$haul->name}}</td>
                <td>{{$haul->phone}}</td>
                <td>{{$haul->address}}</td>
                <td>{{$item->arwah_type.' '.$item->arwah_name }}</td>
                <td>{{$item->arwah_address }}</td>
            </tr>
        @endforeach
        {{-- <tr rowspan="{{$haul->arwahs->count()}}">
            <td>{{ $haul->name }}</td>
            <td>{{ $haul->phone }}</td>
            <td>{{ $haul->address }}</td>
            <td>{{ $haul->arwahs }}</td>
        </tr> --}}
    @endforeach
    </tbody>
</table>