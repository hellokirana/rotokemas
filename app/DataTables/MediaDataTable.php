<?php

namespace App\DataTables;

use App\Models\Media;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MediaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('image', function ($model) {
                return '<img src="' . $model->image_url . '" class="img-fluid">';
            })
            ->editColumn('status', function ($model) {
                return @$model->status_text;
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at ? $model->created_at->format('d M Y H:i') : '-';
            })
            ->editColumn('status', function ($model) {
                return @$model->status_text;
            })
            ->editColumn('featured', function ($model) {
                return @$model->featured == 1 ? "Ya" : "Tidak";
            })
            ->editColumn('kategori_id', function ($model) {
                return @$model->kategori->title;
            })
            ->addColumn('action', function ($row) {
                $button = '<a href="' . url('data/media/' . $row->id . '/edit') . '" class="btn btn-warning btn-sm mx-1" data-bs-toggle="tooltip" title="Edit"><i class="ri-file-edit-line"></i></a>';
                $button .= '<a href="#" data-url_href="' . route('media.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1 delete-post" data-bs-toggle="tooltip" title="Delete"  data-csrf="' . csrf_token() . '"><i class="ri-delete-bin-2-line"></i></a>';

                return $button;
            })
            ->rawColumns(['image', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Media $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('medias-table')
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
            Column::make('created_at')->title('Tanggal Publish'),
            Column::make('image')->title('Gambar')->width(50)->orderable(false)->searchable(false),
            Column::make('kategori_id')->title('Kategori')->orderable(false)->searchable(false),
            Column::make('title')->title('Judul'),
            Column::make('penulis')->title('Penulis'),

            Column::make('featured')->title('Featured'),
            Column::make('status')->title('Status')->width(50)->orderable(false)->searchable(false),
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
        return 'Media_' . date('YmdHis');
    }
}
