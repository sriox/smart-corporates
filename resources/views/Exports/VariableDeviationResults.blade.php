<table>
    <tr>
        <td style="font-weight: bold">Área</td>
        <td style="font-weight: bold">Variable</td>
        <td style="font-weight: bold">Indicador</td>
        @foreach ($groupData as $group)
            <td style="font-weight: bold">{{ $group->name }}</td>
        @endforeach
    </tr>
    @foreach ($questions as $question)
        <tr>
            <td>{{ $question->attribute->dimension->name }}</td>
            <td>{{ $question->attribute->name }}</td>
            <td>{{ $question->variable }}</td>
            @foreach ($groupData as $group)
                <td>
                    {{ $results[$question->id][$group->id] ?? 0 }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
