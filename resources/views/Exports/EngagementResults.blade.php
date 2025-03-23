<table>
    <tr>
        <td style="font-weight: bold">{{ $groupName }}</td>
        @foreach ($groupData as $group)
            <td style="font-weight: bold">{{ $group->name }}</td>
        @endforeach
    </tr>
    <tr>
        <td>Engagement</td>
        @foreach ($groupData as $group)
            <td style="background-color: #{{ $colors[$group->id] ?? 'D51C00' }}">
                {{ $data[$group->id] ?? 0 }}
            </td>
        @endforeach
    </tr>
</table>
