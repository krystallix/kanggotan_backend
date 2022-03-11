<thead style='font-weight: 700;'>
    <tr>
        <th>No</th>
        <th>Pengirim</th>
        <th>Alamat</th>
        <th>Arwah</th>
        <th>Makam</th>
    </tr>
</thead>
<tbody>
    @foreach ($hauls as $k => $haul)
        {{ $nomer = $k + 1 }}
        @foreach ($haul->arwahs as $key => $item)
            @if ($item->arwah_type == 'Bapak')
                {{ $arwah_type = 'Bp.' }}
            @elseif($item->arwah_type == 'Ibu')
                {{ $arwah_type = 'Ibu.' }}
            @elseif($item->arwah_type == 'Saudara')
                {{ $arwah_type = 'Sdr.' }}
            @elseif($item->arwah_type == 'Adik')
                {{ $arwah_type = 'Adik.' }}    
            @endif
            @if ($key == 0)
                <tr>
                    <td>{{ $nomer }}</td>
                    <td>{{ $haul->name }}</td>
                    <td>{{ $haul->address }}</td>
                    <td>{{ $arwah_type . ' ' . $item->arwah_name }}</td>
                    <td>{{ $item->arwah_address }}</td>
                </tr>
            @else
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>{{ $arwah_type . ' ' . $item->arwah_name }}</td>
                    <td>{{ $item->arwah_address }}</td>
                </tr>
            @endif
        @endforeach
        {{-- <tr rowspan="{{$haul->arwahs->count()}}">
        <td>{{ $haul->name }}</td>
        <td>{{ $haul->phone }}</td>
        <td>{{ $haul->address }}</td>
        <td>{{ $haul->arwahs }}</td>
    </tr> --}}
    @endforeach
</tbody>
