<?php

namespace Modules\App\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait HasCrudActions
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->lang = 'vi';
    }

    public function index(Request $request)
    {
        if ($request->has('table')) {
            return $this->getModel()->table($request);
        }
        return view("{$this->viewPath}.index");
    }

    public function table(Request $request)
    {
        return $this->getModel()->table($request);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array_merge([
            $this->getResourceName() => $this->getModel(),
        ], $this->getFormData('create'), $this->getResourceData());
        return view("{$this->viewPath}.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->disableSearchSyncing();

        $entity = $this->getModel()->create(
            $this->getRequest('store')->all()
        );

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity);
        }
        return response()->json(['success' => true, 'resource' => $this->getLabel().' '.trans('validation.attributes.create_success'), 'url' => route("{$this->getRoutePrefix()}.index")]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = $this->getEntity($id);

        if (request()->wantsJson()) {
            return $entity;
        }
        return view("{$this->viewPath}.show")->with($this->getResourceName(), $entity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array_merge([
            $this->getResourceName() => $this->getEntity($id),
        ], $this->getFormData('edit', $id), $this->getResourceData());
        return view("{$this->viewPath}.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $entity = $this->getEntity($id);

        $this->disableSearchSyncing();
        $entity->update(
            $this->getRequest('update')->all()
        );

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return response()->json(['success' => true, 'resource' => $this->getLabel().' '.trans('validation.attributes.update_success')]);
        }

        return response()->json(['success' => true, 'resource' => $this->getLabel().' '.trans('validation.attributes.update_success')]);
    }

    /**
     * Destroy resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function destroy(Request $request)
    {
        $ids = !empty($request->ids) ? explode(',', $request->ids) : [];
        $result = $this->getModel()
        ->withoutGlobalScope('active')
        ->whereIn('id', $ids)
        ->delete();
        return response()->json([
            'success' => $result
        ]);
    }

    public function status(Request $request)
    {
        $ids = !empty($request->ids) ? explode(',', $request->ids) : [];
        $result = $this->getModel()
        ->withoutGlobalScope('active')
        ->whereIn('id', $ids)
        ->update(['status' => $request->status]);
        return response()->json([
            'success' => $result
        ]);
    }

    /**
     * Get an entity by the given id.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getEntity($id)
    {
        return $this->getModel()
        ->with($this->relations())
        ->withoutGlobalScope('active')
        ->findOrFail($id);
    }

    /**
     * Get the relations that should be eager loaded.
     *
     * @return array
     */
    private function relations()
    {
        return collect($this->with ?? [])->mapWithKeys(function ($relation) {
            return [$relation => function ($query) {
                return $query->withoutGlobalScope('active');
            }];
        })->all();
    }

    /**
     * Get form data for the given action.
     *
     * @param string $action
     * @param mixed ...$args
     * @return array
     */
    protected function getFormData($action, ...$args)
    {
        if (method_exists($this, 'formData')) {
            return  $this->formData(...$args);
        }

        if ($action === 'create' && method_exists($this, 'createFormData')) {
            return $this->createFormData();
        }

        if ($action === 'edit' && method_exists($this, 'editFormData')) {
            return $this->editFormData(...$args);
        }

        return [];
    }

    /**
     * Get name of the resource.
     *
     * @return string
     */
    protected function getResourceName()
    {
        if (isset($this->resourceName)) {
            return $this->resourceName;
        }

        return lcfirst(class_basename($this->model));
    }

    /**
     * Get label of the resource.
     *
     * @return void
     */
    protected function getLabel()
    {
        return trans($this->label);
    }

    /**
     * Get route prefix of the resource.
     *
     * @return string
     */
    protected function getRoutePrefix()
    {
        if (isset($this->routePrefix)) {
            return $this->routePrefix;
        }

        return "admin.{$this->getModel()->getTable()}";
    }

    /**
     * Get a new instance of the model.
     *
     * @return void
     */
    protected function getModel()
    {
        return new $this->model;
    }

    /**
     * Get request object
     *
     * @param string $action
     * @return \Illuminate\Http\Request
     */
    protected function getRequest($action)
    {
        if (! isset($this->validation)) {
            return request();
        }

        if (isset($this->validation[$action])) {
            return resolve($this->validation[$action]);
        }

        return resolve($this->validation);
    }

    /**
     * Disable search syncing for the entity.
     *
     * @return void
     */
    protected function disableSearchSyncing()
    {
        if ($this->isSearchable()) {
            $this->getModel()->disableSearchSyncing();
        }
    }

    /**
     * Determine if the entity is searchable.
     *
     * @return bool
     */
    protected function isSearchable()
    {
        return in_array(Searchable::class, class_uses_recursive($this->getModel()));
    }

    /**
     * Make the given model instance searchable.
     *
     * @return void
     */
    protected function searchable($entity)
    {
        if ($this->isSearchable($entity)) {
            $entity->searchable();
        }
    }

    public function getResourceData()
    {
        return [];
    }
}
