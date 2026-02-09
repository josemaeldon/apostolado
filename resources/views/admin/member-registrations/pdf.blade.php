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
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .page-break {
            page-break-after: always;
        }

        .registration-card {
            padding: 20px;
            border: 2px solid #2563eb;
            border-radius: 8px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2563eb;
        }

        .header h1 {
            font-size: 18px;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 10px;
            color: #6b7280;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            margin-top: 5px;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .section {
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 6px;
            padding: 4px 8px;
            background-color: #eff6ff;
            border-left: 3px solid #2563eb;
        }

        .data-grid {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .data-row {
            display: table-row;
        }

        .data-cell {
            display: table-cell;
            padding: 4px 8px;
            vertical-align: top;
            width: 50%;
        }

        .data-cell-full {
            display: block;
            padding: 4px 8px;
            width: 100%;
        }

        .label {
            font-weight: bold;
            color: #4b5563;
            font-size: 10px;
            display: block;
            margin-bottom: 2px;
        }

        .value {
            color: #1f2937;
            font-size: 11px;
        }

        .commitments {
            margin-top: 8px;
        }

        .commitment-item {
            padding: 3px 0 3px 16px;
            position: relative;
            font-size: 10px;
            line-height: 1.5;
        }

        .commitment-item:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #059669;
            font-weight: bold;
            font-size: 12px;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #6b7280;
        }

        .profile-photo-section {
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 4px;
        }

        .profile-photo {
            max-width: 120px;
            max-height: 150px;
            border: 2px solid #2563eb;
            border-radius: 4px;
            display: block;
            margin: 0 auto;
        }

        .photo-placeholder {
            width: 120px;
            height: 150px;
            border: 2px dashed #9ca3af;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background-color: #ffffff;
            color: #6b7280;
            font-size: 10px;
            text-align: center;
            padding: 10px;
        }

        .additional-info {
            background-color: #f9fafb;
            padding: 8px;
            border-radius: 4px;
            margin-top: 6px;
        }

        .additional-info .value {
            font-size: 10px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    @foreach($registrations as $index => $registration)
        <div class="registration-card">
            <div class="header">
                <h1>FICHA CADASTRAL - APOSTOLADO DA ORAÇÃO</h1>
                <div class="subtitle">Cadastro #{{ $registration->id }} - {{ $registration->created_at->format('d/m/Y H:i') }}</div>
                <div>
                    <span class="status-badge 
                        @if($registration->status == 'pending') status-pending
                        @elseif($registration->status == 'approved') status-approved
                        @elseif($registration->status == 'rejected') status-rejected
                        @endif">
                        @if($registration->status == 'pending') PENDENTE
                        @elseif($registration->status == 'approved') APROVADO
                        @elseif($registration->status == 'rejected') REJEITADO
                        @endif
                    </span>
                </div>
            </div>

            <!-- Profile Photo -->
            <div class="profile-photo-section">
                @if($registration->profile_image && Storage::disk('public')->exists($registration->profile_image))
                    <img src="{{ public_path('storage/' . $registration->profile_image) }}" alt="Foto de Perfil" class="profile-photo">
                @else
                    <div class="photo-placeholder">
                        <div>
                            <div style="font-size: 12px; margin-bottom: 5px;">📷</div>
                            <div>Espaço para foto</div>
                            <div style="font-size: 8px; margin-top: 3px;">(Cole a foto aqui)</div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="section">
                <div class="section-title">Paróquia de Origem</div>
                <div class="data-cell-full">
                    <span class="value">{{ $registration->parish }}</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Dados Pessoais</div>
                <div class="data-grid">
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="label">Nome Completo:</span>
                            <span class="value">{{ $registration->full_name }}</span>
                        </div>
                        <div class="data-cell">
                            <span class="label">CPF:</span>
                            <span class="value">{{ $registration->cpf ?? 'Não informado' }}</span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="label">Email:</span>
                            <span class="value">{{ $registration->email }}</span>
                        </div>
                        <div class="data-cell">
                            <span class="label">Telefone/WhatsApp:</span>
                            <span class="value">{{ $registration->phone }}</span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="label">Data de Nascimento:</span>
                            <span class="value">{{ $registration->birth_date->format('d/m/Y') }}</span>
                        </div>
                        <div class="data-cell">
                            <span class="label">Estado Civil:</span>
                            <span class="value">{{ $registration->marital_status }}</span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="label">Profissão:</span>
                            <span class="value">{{ $registration->profession }}</span>
                        </div>
                        <div class="data-cell">
                            <span class="label">Cidade:</span>
                            <span class="value">{{ $registration->member_city }}</span>
                        </div>
                    </div>
                </div>
                <div class="data-cell-full">
                    <span class="label">Endereço:</span>
                    <span class="value">{{ $registration->address }}</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Dados Paroquiais</div>
                <div class="data-grid">
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="label">Paróquia:</span>
                            <span class="value">{{ $registration->member_parish ?? 'Não informado' }}</span>
                        </div>
                        <div class="data-cell">
                            <span class="label">Data de Batismo:</span>
                            <span class="value">{{ $registration->baptism_date ? $registration->baptism_date->format('d/m/Y') : 'Não informado' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($registration->commitment_1 || $registration->commitment_2 || $registration->commitment_3 || $registration->commitment_4 || $registration->commitment_5)
            <div class="section">
                <div class="section-title">Compromissos Assumidos</div>
                <div class="commitments">
                    @if($registration->commitment_1)
                        <div class="commitment-item">Oferecer diariamente a vida, as orações, as obras e os sofrimentos</div>
                    @endif
                    @if($registration->commitment_2)
                        <div class="commitment-item">Rezar pelas intenções de oração mensais do Papa</div>
                    @endif
                    @if($registration->commitment_3)
                        <div class="commitment-item">Participar das reuniões mensais do Apostolado da Oração</div>
                    @endif
                    @if($registration->commitment_4)
                        <div class="commitment-item">Dedicar-se à adoração ao Santíssimo Sacramento</div>
                    @endif
                    @if($registration->commitment_5)
                        <div class="commitment-item">Participar ativamente das missas do Sagrado Coração de Jesus</div>
                    @endif
                </div>
            </div>
            @endif

            @if($registration->how_met || $registration->why_join)
            <div class="section">
                <div class="section-title">Informações Adicionais</div>
                @if($registration->how_met)
                <div class="additional-info">
                    <span class="label">Como conheceu o Apostolado?</span>
                    <span class="value">{{ $registration->how_met }}</span>
                </div>
                @endif
                @if($registration->why_join)
                <div class="additional-info" style="margin-top: 6px;">
                    <span class="label">Por que deseja ingressar?</span>
                    <span class="value">{{ $registration->why_join }}</span>
                </div>
                @endif
            </div>
            @endif

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
