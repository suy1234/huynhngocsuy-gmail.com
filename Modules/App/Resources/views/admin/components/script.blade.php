<script type="text/javascript">
    var data = {!! json_encode($data['data']) !!}
var HomeReportOrder = new HomeReportOrderApp('#positionID');
function HomeReportOrderApp(element){
    var timeout = null;
    var vm = this.vm = new Vue({
        el: element,
        data: {
            calculating: false,
            isLoadingUpdate: false,
            isLoading: false,
            data: data,
            pagination:{
                limit :{{ $data['total'] }},
                current : 1,
                numRow: 10,
                page : 1,
                total: {{ $data['last_page'] }},
                keyword: '',
            },
            form:{
                title: 'Thêm mới chức vụ',
                name: '',
                code: '',
                id: '',
                isLoading: false,
                isLoadingNew: false
            }
        },
        methods: {
           load(number = null ){
                var vm = this;
                var formdata = new FormData;
                if(vm.pagination.keyword != ''){
                    formdata.append('keyword' , vm.pagination.keyword);
                    vm.pagination.page = 1;
                }
                if( number != undefined){
                    formdata.append('page' , number);
                }
                else
                {
                    formdata.append('page' , vm.pagination.page);
                }
                formdata.append('numRow' , vm.pagination.numRow);
                vm.isLoading  = true;
                var url = '{{ route("admin.position.filter") }}';
                helper.post( url , formdata ,15000)
                .done( function(res , status , xhr){
                    vm.isLoading  = false;
                    vm.checkAll = false;
                    if( res.hasOwnProperty('data')){
                        vm.data = res.data;
                    }
                    if( res.hasOwnProperty('current_page')){
                        vm.pagination.current = res.current_page;
                    }
                    if( res.hasOwnProperty('total')){
                        if( res.total != vm.pagination.total ){
                            vm.pagination.total = res.last_page;
                        }
                    }
                })
                .fail(function(err){
                    vm.isLoading  = false;
                    helper.showNotification('Thực hiện thao tác không thành công !!!', 'danger', 1000);
                })
            },
            filterData: function(e) {    
                this.load();
            },
            setStatus: function (id, index) {
                var vm = this;
                $("#item_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw text-den"></i>');
                var formdata = new FormData;
                var url = '{{ route('admin.position.status') }}'
                formdata.append('id' , id);
                helper.post( url , formdata ,15000)
                .done( function(res , status , xhr){
                    if( res.success == true){
                        $("#item_"+id).html(' <i class="fa fa-power-off"></i>');
                        vm.data[index].status = res.status;
                        helper.showNotification(res.msg, 'success', 1000);
                    }                    
                })
                .fail(function(err){
                    $("#item_"+id).html(' <i class="fa fa-power-off"></i>');
                    helper.showNotification(res.msg, 'danger', 1000);
                })
            },
            dropPositionById(id) {
                var vm = this;
                var callbacktrue = function(vm){
                    var formdata = new FormData;
                    var url = '{{ route('admin.position.delete') }}'
                    formdata.append('id' , id);
                    helper.post( url , formdata ,15000)
                    .done( function(res , status , xhr){
                        if( res.success == true){
                            HomeReportOrder.vm.load(1);
                            helper.showNotification(res.msg, 'success', 1000);
                        }                    
                    })
                    .fail(function(err){
                        helper.showNotification(res.msg, 'danger', 1000);
                    })
                };
                var callbackfalse = function(){};
                helper.confirmDialogMulti(
                    'Cảnh báo !!!',
                    'Bạn có muốn xóa chức vụ này không', 
                    'red', 
                    'Hủy thao tác', 
                    'btn btn-danger waves-effect w-md waves-light', 
                    'Vâng tôi muốn', 
                    'btn btn-success btn-rounded w-md waves-effect waves-light', 
                    callbackfalse,
                    callbacktrue
                );
            },
            myModal(){
                var vm = this;
                vm.isLoadingUpdate = false;
                vm.form.title = 'Thêm mới chức vụ';
                vm.form.name = '';
                vm.form.code = '';
                vm.form.employeesID = '';
                $("#myModal").modal('show');
            },
            createPosition:function (action) {
                var vm = this;
                vm.form.isLoading = false;
                    vm.form.isLoadingNew = false;
                if(action == 'close'){
                    vm.form.isLoading = true;
                }
                else{
                    vm.form.isLoadingNew = true;
                }
                if(vm.form.name == '' || vm.form.name == null){
                    helper.showNotification('Không đươc bỏ trống tên chức vụ', 'danger', 1000);
                    vm.form.isLoading = false;
                    vm.form.isLoadingNew = false;
                    $("input[name=name]").addClass('red-border').focus();
                    setTimeout(function(){ $("input[name=name]").removeClass('red-border'); }, 3000);
                    return ;
                }
                if(vm.form.code == '' || vm.form.code == null){
                    helper.showNotification('Không được bỏ trống mã chức vụ', 'danger', 1000);
                    $("input[name=code]").addClass('red-border').focus();
                    setTimeout(function(){ $("input[name=code]").removeClass('red-border'); }, 3000);
                    vm.form.isLoading = false;
                    vm.form.isLoadingNew = false;
                    return ;
                }
                var formdata = new FormData;
                var url = '{{ route('admin.position.create') }}'
                formdata.append('name' , vm.form.name);
                formdata.append('code' , vm.form.code);
                helper.post( url , formdata ,15000)
                .done( function(res , status , xhr){
                    if( res.success == true){
                        if(action == 'close'){
                            $('#myModal').modal('hide');
                        }
                        vm.form.title = 'Thêm mới chức vụ';
                        vm.form.name = '';
                        vm.form.code = '';
                        vm.load(1);
                        var dataForm = new FormData();
                        dataForm.append( 'id', res.data.id );
                        dataForm.append( 'languageCode', res.data.languageCode );
                        //helper.languageCode('{{route("admin.position.trans")}}', dataForm);
                    }
                    else{
                        if(jQuery.type( res.msg ) === "string"){
                            helper.showNotification(res.msg, 'danger', 1000);
                        }
                        else{
                            $.each( res.msg, function( key, value ) {
                                $("input[name="+key+"]").addClass('red-border').focus();
                                helper.showNotification(value, 'danger', 1000);
                                setTimeout(function(){ $("input[name="+key+"]").removeClass('red-border'); }, 3000);
                            });
                        }
                    }
                    vm.form.isLoading = false;
                        vm.form.isLoadingNew = false;                   
                })
                .fail(function(err){
                    helper.showNotification(res.msg, 'danger', 1000);
                })
            },
            getUpdate(index, id){
                var vm = this;
                if(vm.data[index].id == id){
                    vm.isLoadingUpdate = true;
                    vm.form.title = 'Sửa chức vụ: '+vm.data[index].name;
                    vm.form.id = vm.data[index].id;
                    vm.form.name = vm.data[index].name;
                    vm.form.code = vm.data[index].code;
                    vm.form._id = vm.data[index].id;
                    $('#myModal').modal('show');
                }
                
            },
            updatePosition:function () {
                var vm = this;
                vm.form.isLoading = true;
                var formdata = new FormData;
                var url = '{{ route('admin.position.update') }}';
                if(vm.form.name == '' || vm.form.name == null){
                    helper.showNotification('Không đươc bỏ trống tên chức vụ', 'danger', 1000);
                    vm.form.isLoading = false;
                    vm.form.isLoadingNew = false;
                    $("input[name=name]").addClass('red-border').focus();
                    setTimeout(function(){ $("input[name=name]").removeClass('red-border'); }, 3000);
                    return ;
                }
                if(vm.form.code == '' || vm.form.code == null){
                    helper.showNotification('Không được bỏ trống mã chức vụ', 'danger', 1000);
                    $("input[name=code]").addClass('red-border').focus();
                    setTimeout(function(){ $("input[name=code]").removeClass('red-border'); }, 3000);
                    vm.form.isLoading = false;
                    vm.form.isLoadingNew = false;
                    return ;
                }
                formdata.append('id' , vm.form._id);
                formdata.append('name' , vm.form.name);
                formdata.append('code' , vm.form.code);
                helper.post( url , formdata ,15000)
                .done( function(res , status , xhr){
                    if( res.success == true){
                        $('#myModal').modal('hide');
                        vm.isLoadingUpdate = false;
                        vm.form.title = 'Thêm mới chức vụ';
                        vm.form.name = '';
                        vm.form.code = ''; 
                        vm.load();
                        helper.showNotification(res.msg, 'success', 1000); 
                    }
                    else{
                        if(jQuery.type( res.msg ) === "string"){
                            helper.showNotification(res.msg, 'danger', 1000);
                        }
                        else{
                            $.each( res.msg, function( key, value ) {
                                $("input[name="+key+"]").addClass('red-border').focus();
                              helper.showNotification(value, 'danger', 1000);
                              setTimeout(function(){ $("input[name="+key+"]").removeClass('red-border'); }, 3000);
                            });
                        }
                    }
                    vm.form.isLoading = false;
                    vm.form.isLoadingNew = false;          
                })
                .fail(function(err){
                        helper.showNotification('Error 404', 'danger', 1000);
                    
                    vm.form.isLoading = false;
                    vm.form.isLoadingNew = false;
                })
            }
        },
        computed:{

        },
        mounted() {
            var _this = this;
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
        },
        created: function () {
            // this.load();
            this.calculating = true;
        },
    })
    return this;
}
</script>       