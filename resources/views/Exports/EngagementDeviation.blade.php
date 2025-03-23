<table>
    <tr>
        <td style="font-weight: bold">{{ $groupName }}</td>
        @foreach ($groupData as $group)
            <td style="font-weight: bold">{{ $group->name }}</td>
        @endforeach
    </tr>
    <tr>
        <td>Desviación Engagement</td>
        @foreach ($groupData as $group)
            <td>
                {{ $data[$group->id] ?? 0 }}
            </td>
        @endforeach
    </tr>
</table>
