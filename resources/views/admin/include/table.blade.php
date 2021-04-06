<table class="table table-striped">
    <thead>
        @if(count($field) > 0)
            @foreach($field as $key => $f)
                <th>{{ $f['alias_name'] }}</th>
            @endforeach
            @if($use_action)
            <th>Aksi</th>
            @endif
        @endif
    </thead>
    <tbody>
    @if($data->total() > 0)
        @foreach($data->items() as $key_item => $item)
            @if(count($field) > 0)
                <tr>
                    @foreach($field as $key => $d)
                        <td data-name="{{ $item[ $d['name'] ] }}">{{ $item[ $d['name'] ] }}</td>
                    @endforeach
                    @if($use_action)
                        <td>
                            @include('admin.include.action')
                        </td>
                    @endif
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="{{ count($field) + 1 }}" style="text-align:center;"> Tidak ada data yang ditampilkan</td>
        </tr>
    @endif
    </tbody>
</table>