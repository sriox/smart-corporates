<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <tr>
            <td>Persona</td>
            <td>Genero</td>
            <td>Area</td>
            <td>Grupo</td>
            <td>División</td>
            <td>Antiguedad</td>
            <td>Edad</td>
            @foreach ($questions as $question)
                <td>{{ $question->question }}</td>
            @endforeach
        </tr>
        @foreach ($participants as $participant)
            <tr>
                <td>{{ $participant->person }}</td>
                <td>{{ $participant->gender }}</td>
                <td>{{ $participant->area }}</td>
                <td>{{ $participant->group }}</td>
                <td>{{ $participant->division }}</td>
                <td>{{ $participant->ancient }}</td>
                <td>{{ $participant->age }}</td>
                @foreach ($questions as $question)
                    <td>{{ $answers[$participant->participant_id][$question->id] }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>

</html>
