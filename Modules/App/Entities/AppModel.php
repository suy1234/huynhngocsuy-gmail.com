<?php

namespace Modules\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class AppModel extends Model
{
	protected $appends = [
        'status_text',
    ];
    public function table($request)
    {
        Carbon::setLocale(getLangCode());
        $numRow = !empty($request->numRow) ? $request->numRow : 10;
        $query = $this->search($request);
        $query = $query->where('lang', getLangCode());
        if(!empty($status = request()->filter['status'])){
            $query = $query->where('status', $status);
        }
        return $query->orderBy('created_at', 'desc')->orderBy('status', 'desc')->paginate($numRow);
    }

    public function getStatusTextAttribute()
    {
        $class = config('core.status_class.'.$this->status);
        return '<span class="font-size-base font-weight-normal badge badge-flat border-'.$class.' text-'.$class.'">'.trans($this->module.'::'.$this->table.'.status.'.$this->status).'</span>';
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
}