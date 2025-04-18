<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MemberDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function ($model) {
                return @$model->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('joined_at', function ($model) {
                // More careful null checking
                if (!$model->joined_at)
                    return '-';

                // Try to ensure it's a Carbon instance
                if (is_string($model->joined_at)) {
                    return date('d-m-Y', strtotime($model->joined_at));
                }

                return $model->joined_at->format('d-m-Y');
            })
            ->addColumn('action', function ($row) {
                $currentRoute = request()->route()->getName();
                $button = '';

                // Add info button for both pending and approved members
                $button .= '<a href="' . url('data/member/' . $row->id . '/edit') . '" class="btn btn-warning btn-sm mx-1" data-bs-toggle="tooltip" title="info"><i class="ri-file-info-line"></i></a>';

                if ($currentRoute === 'pending-members.index') {
                    // Add approve & reject buttons for pending members
                    $approveUrl = route('member.approve', $row->id);
                    $rejectUrl = route('member.reject', $row->id);

                    $button .= '<button type="button" class="btn btn-success btn-sm mx-1 btn-approve" data-url="' . $approveUrl . '" data-csrf="' . csrf_token() . '" data-id="' . $row->id . '">Approve</button>';
                    $button .= '<button type="button" class="btn btn-danger btn-sm mx-1 btn-reject" data-url="' . $rejectUrl . '" data-csrf="' . csrf_token() . '" data-id="' . $row->id . '">Reject</button>';
                } else {
                    // Add delete button for approved members
                    $button .= '<a href="#" data-url_href="' . route('member.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1 delete-post" data-bs-toggle="tooltip" title="Delete" data-csrf="' . csrf_token() . '"><i class="ri-delete-bin-2-line"></i></a>';
                }

                return $button;
            })
            ->rawColumns(['image', 'action']);

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        $query = $model->newQuery()->role('member');

        if (request()->routeIs('pending-members.index')) {
            $query->where('status', 'pending');
        } else {
            $query->where('status', 'approved');
        }

        return $query->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('User-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                // Button::make('excel'),
                // Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('joined_at')->title('Tanggal Bergabung'),
            Column::make('company_name')->title('Nama Perusahaan'),
            Column::make('email')->title('Email Perusahaan'),
            Column::make('type')->title('Tipe Member'),
            Column::make('founded_year')->title('Tahun Berdiri'),
            Column::make('company_address')->title('Alamat Perusahaan'),
            Column::make('company_phone')->title('Telepon Perusahaan'),
            Column::make('company_website')->title('Website Perusahaan'),
            Column::make('business_type')->title('Badan Usaha'),
            Column::make('total_employee')->title('Jumlah Total Karyawan'),
            Column::make('printing_line_total')->title('Jumlah Printing Line'),
            Column::make('process_printing')->title('Proses Printing'),
            Column::make('process')->title('Proses Produksi'),
            Column::make('anual_turnover')->title('Omzet Tahunan'),
            Column::make('film_production')->title('Produksi Film'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
