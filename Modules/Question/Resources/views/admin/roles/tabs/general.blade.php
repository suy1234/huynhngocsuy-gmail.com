<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="form-group">
			<label for="title">
				{{ trans('user::departments.department') }}<code>*</code>
			</label> 
			<select2 id="department_id" v-model="form.department_id" :options="departments" name="department_id" placeholder="{{ trans('validation.attributes.select') }}"></select2>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="form-group">
			<label for="title">
				{{ trans('user::positions.position') }}<code>*</code>
			</label> 
			<select2 id="position_id" v-model="form.position_id" :options="positions" name="position_id" placeholder="{{ trans('validation.attributes.select') }}"></select2>
		</div>
	</div>
</div>
@php( $permissions = !empty($role->permissions) ? array_fill_keys(explode(',', $role->permissions), true) : [] )
<div class="row">
	@foreach(config('permissions') as $key => $array)
	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="tree-checkbox-hierarchical card card-body border-left-danger border-left-2">
			<p>
				<strong>{{ trans($key.'::'.$key.'s.module') }}</strong>
			</p>
			<ul class="mb-0">
				@foreach($array as $key1 => $item)
				<li class="expanded">{{ trans($key.'::'.$key1.'s.'.$key1) }}
					<ul>
						@foreach($item as $value)
						<li @if(!empty($permissions['admin.'.$key1.'s.'.$value])) class="selected" @endif data-value="admin.{{ $key1 }}s.{{ $value }}">
							<span data-value="admin.{{ $key1 }}s.{{ $value }}">
								{{ trans('resource.'.$value) }} {{ mb_strtolower(trans($key.'::'.$key1.'s.module'), 'UTF-8') }}
							</span>
						</li>
						@endforeach
					</ul>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
	@endforeach
</div>
@push('script')
<script src="{{ asset('public/admin/app/js/plugins/extensions/jquery_ui/core.min.js') }}"></script>
<script src="{{ asset('public/admin/app/js/plugins/extensions/jquery_ui/effects.min.js') }}"></script>
<script src="{{ asset('public/admin/app/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
<script src="{{ asset('public/admin/app/js/plugins/trees/fancytree_all.min.js') }}"></script>
<script src="{{ asset('public/admin/app/js/plugins/trees/fancytree_childcounter.js') }}"></script>
<script type="text/javascript">
	var mix = {
		data: {
			departments : {!! $departments !!},
			positions : {!! $positions !!},
			form: {
				department_id: '{{ @$role->department_id }}',
				position_id: '{{ @$role->position_id }}',
				permissions: <?php echo !empty($role->permissions) ? json_encode(explode(',', $role->permissions)) : '[]' ?>
			}
		},
		methods: {

		},
		mounted() {
			var vm = this;
			$('.tree-checkbox-hierarchical').fancytree({
				checkbox: true,
				selectMode: 4,
				click: function(event, data){
					if(data.node.data.value != '' && data.node.data.value !== undefined){
						vm.form.permissions.push(data.node.data.value);
					}
					console.log(data.node.data.value);
				},
			});
			var switcherySelect = document.querySelector('.form-input-switchery');
			var initSelect = new Switchery(switcherySelect);
			switcherySelect.onchange = function() {
				if(switcherySelect.checked) {
					$('.tree-checkbox-toggle').fancytree('getTree').visit(function(node){
						node.setSelected(true);
					});
					return false;
				}
				else {
					$('.tree-checkbox-toggle').fancytree('getTree').visit(function(node){
						node.setSelected(false);
					});
					return false;
				}
			};
		}
	}
</script>
@endpush