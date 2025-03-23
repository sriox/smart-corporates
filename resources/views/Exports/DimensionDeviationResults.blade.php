<table>
    <tr>
        <td style="font-weight: bold">Área</td>
        @foreach ($groupData as $group)
            <td style="font-weight: bold">{{ $group->name }}</td>
        @endforeach
    </tr>
    @foreach ($dimensions as $dimension)
        <tr>
            <td>{{ $dimension->name }}</td>
            @foreach ($groupData as $group)
                <td>
                    {{ $results[$dimension->id][$group->id] ?? 0 }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
