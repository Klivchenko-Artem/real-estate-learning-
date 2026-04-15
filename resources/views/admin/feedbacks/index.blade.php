@extends('layouts.admin')

@section('title', 'Заявки')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Заявки</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Заявки</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="feedbacks-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Email</th>
                        <th>Сообщение</th>
                        <th>Дата</th>
                        <th>Статус</th>
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
    $('#feedbacks-table').DataTable({
        serverSide: true,
        processing: true,
        ajax: '{{ route("admin.feedbacks.table") }}',
        columns: [
            { data: 'id', width: '50px' },
            { data: 'name' },
            { data: 'phone' },
            { data: 'email', defaultContent: '—' },
            { data: 'message', defaultContent: '—', render: (d) => d ? d.substring(0, 60) + '...' : '—' },
            { data: 'created_at' },
            { data: 'actions', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']],
        language: { url: '/assets/admin/js/datatable-ru.json' }
    });
});
</script>
@endpush
