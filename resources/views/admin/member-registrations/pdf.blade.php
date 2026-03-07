<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros de Membros</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #3b0a0a;
            font-size: 10px;
            line-height: 1.35;
            background-color: #fff;
        }

        .sheet {
            border: 2px solid #9f1239;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .header {
            background: #9f1239;
            color: #fff;
            padding: 12px 16px;
        }

        .header-row {
            width: 100%;
            border-collapse: collapse;
        }

        .header-row td {
            vertical-align: middle;
        }

        .brand {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 9px;
            margin-top: 3px;
            color: #ffd7e1;
        }

        .meta {
            text-align: right;
            font-size: 9px;
        }

        .status {
            display: inline-block;
            margin-top: 4px;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            background: #fff;
        }

        .status.pending {
            color: #9a3412;
            border: 1px solid #fdba74;
        }

        .status.approved {
            color: #14532d;
            border: 1px solid #86efac;
        }

        .status.rejected {
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .block-title {
            background: #fee2e2;
            color: #7f1d1d;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-size: 9px;
            padding: 6px 10px;
            border-top: 1px solid #fecdd3;
            border-bottom: 1px solid #fecdd3;
        }

        .grid {
            width: 100%;
            border-collapse: collapse;
        }

        .grid td {
            border: 1px solid #fecdd3;
            padding: 6px 8px;
            vertical-align: top;
        }

        .label {
            font-size: 8px;
            color: #9f1239;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.35px;
            margin-bottom: 2px;
        }

        .value {
            font-size: 10px;
            color: #3f111a;
            font-weight: 500;
            word-break: break-word;
        }

        .photo-cell {
            width: 120px;
            text-align: center;
            background: #fff7f7;
        }

        .photo {
            width: 88px;
            height: 112px;
            object-fit: cover;
            border: 2px solid #be123c;
            border-radius: 4px;
            margin: 0 auto 5px;
            display: block;
        }

        .photo-placeholder {
            width: 88px;
            height: 112px;
            border: 2px dashed #fb7185;
            border-radius: 4px;
            margin: 0 auto 5px;
            display: table;
            background: #fff;
        }

        .photo-placeholder span {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            color: #9f1239;
            font-size: 9px;
            padding: 6px;
        }

        .commitments {
            padding: 8px 12px;
            border: 1px solid #fecdd3;
            border-top: none;
            background: #fff;
        }

        .commitments ul {
            margin-left: 16px;
        }

        .commitments li {
            margin-bottom: 4px;
            color: #4c1d1d;
            font-size: 9px;
        }

        .notes {
            border: 1px solid #fecdd3;
            border-top: none;
            background: #fff;
            padding: 8px 10px;
            min-height: 52px;
        }

        .footer {
            padding: 8px 12px;
            background: #fff1f2;
            border-top: 1px solid #fecdd3;
            color: #881337;
            font-size: 8px;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @foreach($registrations as $index => $registration)
        <div class="sheet">
            <div class="header">
                <table class="header-row">
                    <tr>
                        <td>
                            <div class="brand">Apostolado da Oracao</div>
                            <div class="subtitle">Ficha cadastral de membro</div>
                        </td>
                        <td class="meta">
                            <div><strong>Cadastro:</strong> #{{ $registration->id }}</div>
                            <div><strong>Data:</strong> {{ $registration->created_at->format('d/m/Y H:i') }}</div>
                            <div class="status {{ $registration->status }}">
                                @if($registration->status === 'pending') Pendente @endif
                                @if($registration->status === 'approved') Aprovado @endif
                                @if($registration->status === 'rejected') Rejeitado @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="block-title">Identificacao e Foto</div>
            <table class="grid">
                <tr>
                    <td>
                        <div class="label">Nome Completo</div>
                        <div class="value">{{ $registration->full_name }}</div>
                    </td>
                    <td>
                        <div class="label">CPF</div>
                        <div class="value">{{ $registration->cpf ?: 'Nao informado' }}</div>
                    </td>
                    <td class="photo-cell" rowspan="2">
                        @if($registration->profile_image && Storage::disk('public')->exists($registration->profile_image))
                            <img src="{{ public_path('storage/' . $registration->profile_image) }}" alt="Foto" class="photo">
                        @else
                            <div class="photo-placeholder"><span>Sem foto</span></div>
                        @endif
                        <div class="label">Foto do membro</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label">Paroquia de Origem</div>
                        <div class="value">{{ $registration->parish }}</div>
                    </td>
                    <td>
                        <div class="label">Data de Nascimento</div>
                        <div class="value">{{ $registration->birth_date ? $registration->birth_date->format('d/m/Y') : 'Nao informado' }}</div>
                    </td>
                </tr>
            </table>

            <div class="block-title">Contato e Perfil</div>
            <table class="grid">
                <tr>
                    <td>
                        <div class="label">Email</div>
                        <div class="value">{{ $registration->email ?: 'Nao informado' }}</div>
                    </td>
                    <td>
                        <div class="label">Telefone</div>
                        <div class="value">{{ $registration->phone ?: 'Nao informado' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label">Estado Civil</div>
                        <div class="value">{{ $registration->marital_status ?: 'Nao informado' }}</div>
                    </td>
                    <td>
                        <div class="label">Profissao</div>
                        <div class="value">{{ $registration->profession ?: 'Nao informado' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="label">Endereco</div>
                        <div class="value">{{ $registration->address ?: 'Nao informado' }}</div>
                    </td>
                </tr>
            </table>

            <div class="block-title">Dados Eclesiais</div>
            <table class="grid">
                <tr>
                    <td>
                        <div class="label">Cidade do Membro</div>
                        <div class="value">{{ $registration->member_city ?: 'Nao informado' }}</div>
                    </td>
                    <td>
                        <div class="label">Paroquia do Membro</div>
                        <div class="value">{{ $registration->member_parish ?: 'Nao informado' }}</div>
                    </td>
                    <td>
                        <div class="label">Data de Batismo</div>
                        <div class="value">{{ $registration->baptism_date ? $registration->baptism_date->format('d/m/Y') : 'Nao informado' }}</div>
                    </td>
                </tr>
            </table>

            <div class="block-title">Compromissos Assumidos</div>
            <div class="commitments">
                <ul>
                    @if($registration->commitment_1)
                        <li>Oferecer diariamente a vida, as oracoes, as obras e os sofrimentos em uniao com o Coracao de Jesus.</li>
                    @endif
                    @if($registration->commitment_2)
                        <li>Rezar pelas intencoes de oracao mensais do Papa.</li>
                    @endif
                    @if($registration->commitment_3)
                        <li>Participar das reunioes mensais do Apostolado da Oracao.</li>
                    @endif
                    @if($registration->commitment_4)
                        <li>Dedicar-se a adoracao ao Santissimo Sacramento, especialmente nas primeiras sextas-feiras.</li>
                    @endif
                    @if($registration->commitment_5)
                        <li>Participar ativamente das missas do Sagrado Coracao de Jesus.</li>
                    @endif
                    @if(!$registration->commitment_1 && !$registration->commitment_2 && !$registration->commitment_3 && !$registration->commitment_4 && !$registration->commitment_5)
                        <li>Nenhum compromisso registrado.</li>
                    @endif
                </ul>
            </div>

            <div class="block-title">Observacoes</div>
            <div class="notes">
                <div class="label">Como conheceu o Apostolado?</div>
                <div class="value">{{ $registration->how_met ?: 'Nao informado' }}</div>
                <div style="height: 8px;"></div>
                <div class="label">Por que deseja participar?</div>
                <div class="value">{{ $registration->why_join ?: 'Nao informado' }}</div>
            </div>

            <div class="footer">
                Documento gerado em {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

        @if($index < count($registrations) - 1)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
