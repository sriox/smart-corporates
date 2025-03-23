<table>
    <tr>
        <td style="font-weight: bold">Variable</td>
        @foreach ($groupData as $group)
            <td style="font-weight: bold">{{ $group->name }}</td>
        @endforeach
    </tr>
    @foreach ($dimensions as $dimension)
        <tr>
            <td>{{ $dimension->name }}</td>
            @foreach ($groupData as $group)
                <td style="background-color: #{{ $colors[$dimension->id][$group->id] ?? 'D51C00' }}">
                    {{ $results[$dimension->id][$group->id] ?? 0 }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
