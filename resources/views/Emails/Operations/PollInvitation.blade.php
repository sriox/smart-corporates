@extends('Emails.Layouts.EmailLayout')
@section('content')
    <p style="text-align: justify">Apreciado(a) <br /><br /><span style="font-weight: bold">{{ $person->name }}</span>, <br />
    </p>
    <p style="text-align: justify">
        Engagement es el nivel del vínculo emocional que junto con el entusiasmo y pasión por la compañía, se manifiesta en
        dar siempre lo mejor. Para {{ mb_strtoupper($pollInstance->company->name) }} es fundamental su participación en la
        planificación y ejecución de las oportunidades de desarrollo de los colaboradores.
    </p>
    <p style="text-align: justify">
        Por lo anterior, ha sido invitado(a) a participar de la encuesta:
        <span style="font-weight: bold">{{ $pollInstance->poll->name }}</span>, la cual se realizará de forma
        totalmente
        anónima.
    </p>
    <p style="text-align: justify">
        La encuesta estará disponible hasta el <span
            style="font-weight: bold">{{ \Carbon\Carbon::parse($pollInstance->end_at)->format('d/m/Y') }}</span>, por
        favor contestarla lo más pronto posible para garantizar que sus opiniones sean tenidas en cuenta.
    </p>
    <p style="text-align: justify">
        Para iniciar haga click en el link "Iniciar Encuesta" que encontrará a continuación:
    </p>
    </p>
    <table role="presentation" width="100%">
        <tr>
            <td align="center">
                <a href="{{ $link }}"
                    style="padding: 5px 15px; background-color: #EC114F; border-radius: 6px; border: 0;color: white; font-weigth: bold; text-decoration: none;font-familly: verdana">Iniciar
                    Encuesta</a>
            </td>
        </tr>
    </table>
@endsection
