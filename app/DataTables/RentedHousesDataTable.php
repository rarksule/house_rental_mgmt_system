<?php

namespace App\DataTables;

use App\Models\House;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RentedHousesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('Location', function ($house) {
                return 

                $house->latitude
                    ? '<a href="https://www.google.com/maps/@'.$house->latitude.','.$house->longitude.',96m/data=!3m1!1e3?hl=en&entry=ttu&g_ep=EgoyMDI1MDQyMS4wIKXMDSoASAFQAw%3D%3D" target="_blank"
                    <span class="badge bg-success"><i class="fas fa-map-marker-alt"></i>  Location</span>
                </a>'
                    : '';
            })
            ->addColumn('payment_date', function($house) {
                if (!$house->payment_date) {
                    return '--';
                }
                
                $date = \Carbon\Carbon::parse($house->payment_date);
                $day = $date->format('d');
                
                // Add ordinal suffix (st, nd, rd, th)
                $suffix = 'th';
                if (!in_array($day[0], ['1', '2', '3'])) {
                    $suffix = 'th';
                } else {
                    switch ($day % 10) {
                        case 1: $suffix = 'st'; break;
                        case 2: $suffix = 'nd'; break;
                        case 3: $suffix = 'rd'; break;
                    }
                }
                
                return $day . $suffix . ' of month';
            })
            ->addColumn('Rating', function ($house) {
                $rating = $house->reviews->count() > 0 ? $house->reviews->avg("rating") : 0.0;
                return '<i class="badge bg-warning fas fa-star me-1">  '.$rating.'</i>';
            })

            ->addColumn('Tenant', function ($house) {
                return $house->tenant != null
                    ? $house->tenant->first_name
                    : ' --';
            })

            ->addColumn('action', function($house) {
                $buttons = '';
                if (auth()->user()->role == USER_ROLE_OWNER) {
                    $buttons .= '<a href="'.route('owner.editHouse', $house->id).'" class="btn btn-primary btn-sm me-1 mb-1">
                                  <i class="fas fa-edit"></i>
                                </a>';
                }
                
                // Show delete button for all authorized users
                $buttons .= '<button class="btn btn-danger btn-sm delete mb-1" data-id="'.$house->id.'">
                               <i class="fas fa-trash"></i>
                             </button>';
                
                return $buttons;
            })
            ->rawColumns(['Location','Rating', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\House $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(House $model)
    {
        if (isAdmin()) {
            $model = $model->newQuery()->with(['tenant', 'owner', 'reviews'])->where('rented',1);
        } else {
            $model = $model->newQuery()->with(['tenant', 'reviews'])->where('owner_id', auth()->user()->id)->where('rented',1);
        }

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('houses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'asc')
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
{
    $columns = [
        Column::make('id')->title(__("message.id")),
        Column::make('name')->title(__("message.name")),
    ];

    
    if (auth()->user()->role == USER_ROLE_ADMIN) {
        $columns[] = Column::make('owner.first_name')->title(__("message.owner.0"));
    }

    // Add the rest of the columns
    $columns = array_merge($columns, [
        Column::computed('Tenant')->title(__("message.tenant")),
        Column::make('price')->title(__("message.price")),
        Column::make('payment_date')->title(__("message.payment_date")),
        Column::make('address')->title(__("message.address")),
        Column::computed('Location')->title(__("message.location")),
        Column::make('area')->title(__("message.area")),
        Column::computed('Rating')->title(__("message.rating")), 
        Column::computed('action')->title(__("message.action"))
            ->exportable(false)
            ->printable(false)
            ->width(100)
            ->addClass('text-center'),
    ]);

    return $columns;
}

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Houses_' . date('YmdHis');
    }


    public function getViewColumns()
    {
        return $this->getColumns();
    }
}
