<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TenantsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $datatable =  datatables()
            ->eloquent($query)
            ->addColumn('verified', function ($user) {
                return $user->phone_verified_at
                    ? '<span class="badge bg-success">'.__("message.verified").'</span>'
                    : '<span class="badge bg-warning text-dark">'.__("message.pending").'</span>';
            })
            ->addColumn('rentedHouse', function ($user) {
                if($user->rentedHouse!=null){
                    $link = '<a href="'.route("house_detail",[$user->rentedHouse->id]).'"><span class="badge bg-primary">'.__("message.goto_house").'</span></a>';
                }
                
                return $link ?? '---';
            })
            ->addColumn('status', function ($user) {
                $status = $user->status ? __("message.active") : __("message.inactive");
                $color = $user->status ? 'success' : 'danger';
                $statusBadge = '<span class="badge bg-' . $color . '">' . ucfirst($status) . '</span>';

                if (isAdmin()) {
                    return '<a href="javascript:void(0)" class="change-status" data-id="' . $user->id . '">' . $statusBadge . '</a>';
                }

                return $statusBadge;
            });
            if(isAdmin()){
                $datatable
                ->addColumn('action', function ($user) {
                    return  '
                        <a href="' . route('admin.editUsers', $user->id) . '" class="btn btn-primary btn-sm me-1 mb-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete mb-1" data-id="' . $user->id . '" data-type="user">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                });  
            }
            return $datatable->rawColumns(['verified','rentedHouse', 'status', ...(isAdmin() ? ['action'] : [])]);
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        if (isAdmin()) {
            $model = $model->newQuery()->where('role', USER_ROLE_TENANT);
        } else {
            $model = User::whereHas('rentedHouse', function ($query) {
                $query->where('owner_id', auth()->id());
            });

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
            ->setTableId('users-table')
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
        return [
            Column::make('id')->title(__("message.id")),
            Column::make('email')->title(__("message.email")),
            Column::make('first_name')->title(__("message.first_name")),
            Column::make('last_name')->title(__("message.last_name")),
            Column::computed('verified')->title(__("message.verified")),
            Column::make('contact_number')->title(__("message.contact_number")),
            Column::computed('rentedHouse')->title(__("message.rented_house")),
            Column::computed('status')->title(__("message.status")),
            ...(isAdmin() ? [Column::computed('action')->title(__("message.action"))
            ->exportable(false)
            ->printable(false)
            ->width(100)
            ->addClass('text-center')] : [])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }

    public function getViewColumns()
    {
        return $this->getColumns();
    }
}