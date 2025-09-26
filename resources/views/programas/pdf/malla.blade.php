@php
    $brandNavy = '#00264B';
    $brandBlue = '#1A4FD3';
    $brandSky = '#4A84F7';
    $brandOrange = '#E27227';
    $brandGray = '#F3F6F9';
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Malla Curricular - {{ $programa->nombre }}</title>
    <style>
        @page {
            margin: 28mm 18mm 22mm 18mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: {{ $brandNavy }};
            font-size: 12px;
        }

        h1,
        h2,
        h3 {
            margin: 0;
        }

        .header {
            position: fixed;
            top: -20mm;
            left: 0;
            right: 0;
            height: 18mm;
            border-bottom: 2px solid {{ $brandGray }};
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10mm;
        }

        .header .title {
            font-size: 16px;
            font-weight: 800;
            color: {{ $brandNavy }};
        }

        .header .badge {
            background: {{ $brandOrange }};
            color: #fff;
            padding: 4px 10px;
            border-radius: 9999px;
            font-weight: 700;
        }

        .footer {
            position: fixed;
            bottom: -14mm;
            left: 0;
            right: 0;
            height: 12mm;
            border-top: 1px solid {{ $brandGray }};
            font-size: 10px;
            color: #556;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10mm;
        }

        .page-number:before {
            content: counter(page);
        }

        .cover {
            margin-top: 6mm;
            margin-bottom: 10mm;
            padding: 10mm;
            background: linear-gradient(135deg, {{ $brandSky }}22, {{ $brandOrange }}22);
            border: 1px solid {{ $brandGray }};
            border-radius: 10px;
        }

        .title-big {
            font-size: 26px;
            font-weight: 900;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #334;
            font-size: 13px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 12px;
        }

        .card {
            border: 1px solid {{ $brandGray }};
            border-radius: 10px;
            padding: 10px 12px;
            background: #fff;
            break-inside: avoid;
            /* no partir tarjetas */
        }

        .sem-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .sem-title {
            font-weight: 800;
            font-size: 15px;
        }

        .totals .chip {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 700;
            margin-left: 6px;
        }

        .chip-blue {
            background: {{ $brandSky }}22;
            color: {{ $brandBlue }};
        }

        .chip-orange {
            background: {{ $brandOrange }}22;
            color: {{ $brandOrange }};
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 6px 4px;
        }

        th {
            text-align: left;
            font-size: 11px;
            color: #445;
            border-bottom: 1px solid {{ $brandGray }};
        }

        td.name {
            width: 68%;
        }

        td.badges {
            text-align: right;
            white-space: nowrap;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
            margin-left: 4px;
        }

        .b-blue {
            background: {{ $brandSky }}22;
            color: {{ $brandBlue }};
        }

        .b-orange {
            background: {{ $brandOrange }}22;
            color: {{ $brandOrange }};
        }

        .muted {
            color: #667;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="title">Silfer Academia • {{ $programa->nombre }}</div>
        <div class="badge">Malla Curricular</div>
    </div>

    <div class="footer">
        <div class="muted">Generado el {{ now()->format('d/m/Y H:i') }}</div>
        <div class="muted">Página <span class="page-number"></span></div>
    </div>

    {{-- Portada corta --}}
    <div class="cover">
        <div class="title-big">Malla Curricular</div>
        <div class="subtitle">
            Programa: <strong>{{ $programa->nombre }}</strong><br>
            @if (optional($programa->info)->duracion)
                Duración: {{ $programa->info->duracion }} ·
            @endif
            @if (optional($programa->info)->modalidad)
                Modalidad: {{ $programa->info->modalidad }}
            @endif
        </div>
    </div>

    {{-- Semestres en grilla 2x --}}
    <div class="grid">
        @foreach ($semestres as $sem)
            @php
                $cursos = $sem->cursos ?? collect();
                $tCred = $cursos->sum('creditos');
                $tHoras = $cursos->sum('horas');
            @endphp
            <div class="card">
                <div class="sem-head">
                    <div class="sem-title">{{ $sem->nombre }}</div>
                    @if ($cursos->isNotEmpty())
                        <div class="totals">
                            <span class="chip chip-blue">{{ $tCred }} cr</span>
                            <span class="chip chip-orange">{{ $tHoras }} h</span>
                        </div>
                    @endif
                </div>

                @if ($cursos->isEmpty())
                    <div class="muted">Sin cursos registrados.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th style="text-align:right;">Carga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cursos as $c)
                                <tr>
                                    <td class="name">{{ $c->nombre }}</td>
                                    <td class="badges">
                                        <span class="badge b-blue">{{ (int) ($c->creditos ?? 0) }} cr</span>
                                        <span class="badge b-orange">{{ (int) ($c->horas ?? 0) }} h</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
    </div>

</body>

</html>
