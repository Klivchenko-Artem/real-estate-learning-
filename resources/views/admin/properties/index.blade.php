@extends('layouts.admin')

@section('title', 'Объекты недвижимости')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Объекты</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Объекты недвижимости</h4>
        <a href="{{ route('admin.properties.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Добавить объект
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="properties-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Цена</th>
                        <th>Площадь</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function() {
    $('#properties-table').DataTable({
        serverSide: true,
        processing: true,
        ajax: '{{ route("admin.properties.table") }}',
        columns: [
            { data: 'id', width: '50px' },
            { data: 'name' },
            { data: 'category_name', defaultContent: '—' },
            { data: 'price', render: (d) => d ? Number(d).toLocaleString('ru') + ' ₽' : '—' },
            { data: 'area', render: (d) => d ? d + ' м²' : '—' },
            { data: 'status', render: (d) => d ? '<span class="badge bg-success">Активен</span>' : '<span class="badge bg-secondary">Скрыт</span>' },
            { data: 'actions', orderable: false, searchable: false },
        ],
        language: { url: '/assets/admin/js/datatable-ru.json' }
    });
});
</script>
@endpush
