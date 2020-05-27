<div class="row table-data">
    <div class="col-md-12"> <p>{{ auth()->user()->name }}</p>
        <div class="card">
            <div class="card-heading">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <p style="margin-top: 8px;margin-bottom: 0;text-transform: uppercase;"><strong>{{ @$title }}</strong></p>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-10 set-magin">
                                <form v-on:submit.prevent="filterData">
                                    <div class="form-group form-group-feedback form-group-feedback-left form-search">
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ trans('resource.search') }}" v-model="pagination.keyword">
                                        <div class="form-control-feedback form-control-feedback-sm">
                                            <i class="icon-search4"></i>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-2 col-md-2 set-magin">
                                <div class="form-group">
                                    <select class="form-control input-sm form-control-sm select-row" v-model="pagination.numRow">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="50">50</option>
                                        <option value="60">60</option>
                                        <option value="70">70</option>
                                        <option value="80">80</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    @stack('filter')
                </div>
                <div class="pd-1">
                    <ul class="list-inline mb-0 pd-0">
                        <li>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light border-slate dropdown-toggle" data-toggle="dropdown" :disabled="ids.length <= 0" aria-expanded="false">{{ trans('resource.manipulation') }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                    <a v-on:click="destroy" class="dropdown-item">
                                        <i class="icon-trash text-danger"></i> {{ trans('resource.trans') }}
                                    </a>
                                    <a v-on:click="updateStatus(-1)" class="dropdown-item">
                                        <i class="icon-diff-removed text-warning"></i> {{ trans('resource.hide') }}
                                    </a>
                                    <a v-on:click="updateStatus(1)" class="dropdown-item">
                                        <i class="icon-task text-success"></i> {{ trans('resource.show') }}
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                @stack('table')
                <table class="table-hover table">
                    <thead>
                        <tr>
                            @if(!empty($checkbox))
                            <th style="width: 3%;">
                                <div class="form-group mb-0">
                                    <label>
                                        <input type="checkbox" class="checkbox color-primary" v-model="check_all" value="true">
                                    </label>
                                </div>
                            </th>
                            @endif
                            @foreach($thead as $value)
                            <th>{{ $value }}</th>
                            @endforeach
                            <th>{{ trans('resource.status') }}</th>
                            <th>{{ trans('validation.attributes.created_at') }}</th>
                            <th style="width: 15%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!isLoading" v-for="(item, key) in data">
                            @if(!empty($checkbox))
                            <td>
                                <div class="form-group mb-0">
                                    <label>
                                        <input type="checkbox" class="checkbox color-primary checkbox_id" v-model="ids" :value="item.id">
                                    </label>
                                </div>
                            </td>
                            @endif
                            @stack('tbody')
                            <td v-html="item.status_text"></td>
                            <td v-html="item.created_at"></td>
                            <td>
                                <a v-on:click="updateStatusItem(item.status, item.id)" :class="(item.status == 1) ? 'text-success' : 'text-warning'" v-tooltip title="{{ trans('resource.status') }}">
                                    <i class="icon-switch"></i>
                                </a>
                                &nbsp;
                                <a :href="'{{ route("admin.".$resource.".edit", ['id' => '']) }}/'+item.id" class="text-primary" v-tooltip title="{{ trans('resource.edit') }}">
                                    <i class="icon-pencil7"></i>
                                </a>
                                &nbsp;
                                <a class="text-danger" v-on:click="destroy(item.id)" v-tooltip title="{{ trans('resource.trans') }}">
                                    <i class="icon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <template v-if="isLoading">
                        <tr>
                            <td colspan="12">
                                <div class="no-border">
                                    <div class="sk-three-bounce">
                                        <div class="sk-child sk-bounce1"></div>
                                        <div class="sk-child sk-bounce2"></div>
                                        <div class="sk-child sk-bounce3"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 sm-text-center">
                        <p class="pageView">
                            {{ trans('resource.total_row') }}: 
                            <strong class="text-danger">@{{ pagination.limit | money }}</strong>. 
                            {{ trans('resource.total_row_view') }}:
                            <strong class="text-danger">@{{ data.length | money }}</strong>
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 text-right sm-text-center">
                        <pagination :current="pagination.current" v-model="pagination.page" :total="pagination.total"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script type="text/javascript">
    var mix = {
        data: {
            data: [],
            isLoading: false,
            ids: [],
            check_all: false,
            pagination:{
                limit : 0,
                current : 1,
                numRow: 10,
                page : 1,
                total: 0,
                keyword: '',
            },
        },
        methods: {
            load: function(number = null ){
                var vm = this;
                // vm.isLoading = true;
                var formdata = new FormData;
                if(vm.pagination.keyword != ''){
                    formdata.append('keyword' , vm.pagination.keyword);
                    vm.pagination.page = 1;
                }
                if( number != null && number != undefined){
                    vm.pagination.page = number;
                }
                vm.pagination.current = vm.pagination.page;
                formdata.append('page' , vm.pagination.page);
                formdata.append('numRow' , vm.pagination.numRow);
                formdata.append('table' , true);
                helper.post( '{{ $route }}' , formdata ,15000)
                .done( function(res , status , xhr){
                    vm.isLoading = false;
                    vm.data = res.data;
                    vm.pagination.limit = res.total;
                    vm.pagination.total = res.last_page;
                    vm.check_all = false;
                })
                .fail(function(err){
                    vm.isLoading  = false;
                    helper.showNotification('{{ trans('validation.attributes.error') }}', 'danger', 1000);
                })
            },
            filterData: function(e) {    
                this.load();
            },
            updateStatusItem: function(status, id) {
                var vm = this;
                var status_code = 1;
                if(status == 1){
                    status_code = -1;
                }
                vm.ids.push(id);
                vm.updateStatus(status_code);
            },
            updateStatus: function(status) {
                var vm = this;
                // vm.isLoading = true;
                var formdata = new FormData;
                formdata.append('status' , status);
                formdata.append('ids' , vm.ids.toString());
                helper.post( '{{ route("admin.{$resource}.status") }}' , formdata ,15000)
                .done( function(res , status , xhr){
                    vm.isLoading = false;
                    if(res.success){
                        vm.load();
                        vm.ids = [];
                        helper.showNotification('{{ trans('validation.attributes.success') }}', 'success', 1000);
                    }else{
                        helper.showNotification('{{ trans('validation.attributes.error') }}', 'danger', 1000);
                    }
                    
                })
                .fail(function(err){
                    vm.isLoading  = false;
                    helper.showNotification('{{ trans('validation.attributes.error') }}', 'danger', 1000);
                })
            },

            destroy: function(id = '') {    
                var vm = this;
                if(id != ''){
                    vm.ids.push(id);
                }
                var callbacktrue = function(){
                    vm.isLoading = true;
                    var formdata = new FormData;
                    formdata.append('ids' , vm.ids.toString());
                    helper.post( '{{ route("admin.{$resource}.destroy") }}' , formdata ,15000)
                    .done( function(res , status , xhr){
                        vm.isLoading = false;
                        if(res.success){
                            vm.load();
                            vm.ids = [];
                            helper.showNotification('{{ trans('validation.attributes.success') }}', 'success', 1000);
                        }else{
                            helper.showNotification('{{ trans('validation.attributes.error') }}', 'danger', 1000);
                        }
                    })
                    .fail(function(err){
                        vm.isLoading  = false;
                        helper.showNotification('{{ trans('validation.attributes.error') }}', 'danger', 1000);
                    })
                };
                var callbackfalse = function(){};
                helper.confirmDialogMulti(
                    '{{ trans('validation.attributes.alert') }}',
                    '{{ trans('validation.delete_alert', ['resource' => mb_strtolower(trans(\Route::getCurrentRoute()->action['module'].'::'.$resource.'.module'), 'UTF-8')]) }}', 
                    'red', 
                    '{{ trans('validation.attributes.alert_cancel') }}', 
                    'btn btn-danger waves-effect w-md waves-light', 
                    '{{ trans('validation.attributes.alert_success') }}', 
                    'btn btn-success btn-rounded w-md waves-effect waves-light', 
                    callbackfalse,
                    callbacktrue
                    );
            },
        },
        watch:{
            'pagination.page': function (newval, oldval) {
                if( newval != oldval){
                    this.load();
                }
            },
            'pagination.numRow': function (newval, oldval) {
                if( newval != oldval){
                    this.load(1);
                }
            },
            'check_all': function (newval, oldval) {
                var vm = this;
                if(this.check_all){
                    for (var i = 0; i < vm.data.length; i++) {
                        vm.ids.push(vm.data[i].id);
                    }
                }
                else{
                    vm.ids = [];
                }
            },
        },
        created: function () {
            this.load();
        }
    }
</script>
@endpush