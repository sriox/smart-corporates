<table>
    <tr>
        <td style="font-weight: bold">Área</td>
        <td style="font-weight: bold">Variable</td>
        @foreach ($groupData as $group)
            <td style="font-weight: bold">{{ $group->name }}</td>
        @endforeach
    </tr>
    @foreach ($attributes as $attribute)
        <tr>
            <td>{{ $attribute->dimension->name }}</td>
            <td>{{ $attribute->name }}</td>
            @foreach ($groupData as $group)
                <td>
                    {{ $results[$attribute->id][$group->id] ?? 0 }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
