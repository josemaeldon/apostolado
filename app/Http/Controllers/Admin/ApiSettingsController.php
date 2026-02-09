<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiSettingsController extends Controller
{
    public function index()
    {
        $apiBaseUrl = url('/api/admin');
        
        $endpoints = [
            [
                'name' => 'Listar Cadastros',
                'method' => 'GET',
                'endpoint' => '/member-registrations',
                'description' => 'Lista todos os cadastros de membros com suporte a filtros e paginação',
                'parameters' => [
                    'search' => 'Buscar por nome (opcional)',
                    'parish' => 'Filtrar por paróquia (opcional)',
                    'status' => 'Filtrar por status: pending, approved, rejected (opcional)',
                    'city' => 'Filtrar por cidade (opcional)',
                    'date_from' => 'Data inicial (opcional)',
                    'date_to' => 'Data final (opcional)',
                    'per_page' => 'Itens por página (padrão: 15)',
                ],
            ],
            [
                'name' => 'Obter Cadastro',
                'method' => 'GET',
                'endpoint' => '/member-registrations/{id}',
                'description' => 'Retorna os detalhes de um cadastro específico',
                'parameters' => [],
            ],
            [
                'name' => 'Criar Cadastro',
                'method' => 'POST',
                'endpoint' => '/member-registrations',
                'description' => 'Cria um novo cadastro de membro',
                'parameters' => [
                    'parish' => 'Nome da paróquia (obrigatório)',
                    'full_name' => 'Nome completo (obrigatório)',
                    'cpf' => 'CPF no formato 000.000.000-00 (obrigatório)',
                    'address' => 'Endereço (obrigatório)',
                    'phone' => 'Telefone (obrigatório)',
                    'email' => 'E-mail (obrigatório)',
                    'birth_date' => 'Data de nascimento (obrigatório)',
                    'marital_status' => 'Estado civil (obrigatório)',
                    'profession' => 'Profissão (obrigatório)',
                    'member_city' => 'Cidade (obrigatório)',
                    'member_parish' => 'Paróquia do membro (opcional)',
                    'baptism_date' => 'Data de batismo (opcional)',
                    'profile_image' => 'Imagem de perfil (opcional)',
                    'status' => 'Status: pending, approved, rejected (opcional, padrão: pending)',
                ],
            ],
            [
                'name' => 'Atualizar Cadastro',
                'method' => 'PUT/PATCH',
                'endpoint' => '/member-registrations/{id}',
                'description' => 'Atualiza um cadastro existente (atualização parcial permitida)',
                'parameters' => [
                    'Qualquer campo do cadastro' => 'Todos os campos são opcionais para atualização',
                ],
            ],
            [
                'name' => 'Excluir Cadastro',
                'method' => 'DELETE',
                'endpoint' => '/member-registrations/{id}',
                'description' => 'Exclui um cadastro de membro',
                'parameters' => [],
            ],
        ];
        
        return view('admin.api-settings', compact('apiBaseUrl', 'endpoints'));
    }
}
