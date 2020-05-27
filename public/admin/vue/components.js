if( typeof VueForm != 'undefined'){
    Vue.use(VueForm, {
        inputClasses: {
            valid: 'form-control-success',
            invalid: 'form-control-danger'
        },
        validators: {
            matches: function (value, attrValue) {
                if(!attrValue) {
                    return true;
                }
                return value === attrValue;
            },
            'password-strength': function (value) {
                return /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/.test(value);
            },
            phone :  function(value){
                return helper.isNumber(value);
            },
            minvalue : function(value , attrValue){
                if(!attrValue) {
                    return true;
                }
                return value >= attrValue;
            }
        }
    });
}
if( typeof jconfirm != 'undefined'){
    jconfirm.defaults = {
        animateFromElement: false,
        smoothContent: true,
        title: '',
        content: '',
        theme: 'material',
        backgroundDismiss: true,
        defaultButtons: {
            close: {
                text : 'Đóng',
                btnClass:'btn-inverse',
                action: function () {
                }
            },
        },
    };
}
if( typeof window.VueTimepicker != 'undefined'){
    Vue.use(window.VueTimepicker);
}
if( typeof VueSelect != 'undefined'){
    Vue.component('v-select', VueSelect.VueSelect);
}


Vue.filter('capitalize', function (value) {
    if (!value) return '';
    var to = _.capitalize(value);
    return to;
})
Vue.filter('text-lowercase', function(value) {
    return (value != '') ? String(value).toLowerCase() : '';
});
Vue.filter('iso-full-time', function(value) {
    return moment(parseInt(value)).format('HH:mm DD/MM');
});

Vue.filter('full-time', function(value) {
    return moment(new Date(parseInt(value) * 1000)).format('HH:mm:ss DD/MM/YYYY');
});
Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(parseInt(value))).format('DD-MM-YYYY')
}
});
Vue.filter('only-day', function(value) {
    return moment(new Date(parseInt(value) * 1000)).format('DD/MM/YYYY');
});
Vue.filter('day', function(value) {
    return moment(new Date(parseInt(value) * 1000)).format('DD');
});
Vue.filter('month', function(value) {
    return moment(new Date(parseInt(value) * 1000)).format('MM');
});
Vue.filter('dd-mm', function(value) {
    return moment(new Date(parseInt(value) * 1000)).format('DD/MM');
});
Vue.filter('prev-month', function(value) {
    return moment(new Date(parseInt(value) * 1000)).subtract(1,'months').endOf('month').format('MM');
});
Vue.filter('money', function(value) {
    return (value == undefined) ? '' :  value.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});
Vue.filter('phone', function (phone) {
    return phone.replace(/[^0-9]/g, '')
    .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
});
Vue.filter('short-money', function(value) {
    if(value>1000000000){
        value = Math.floor((value/1000000000)).toFixed(0);
        return '~ '+value + 'B';
    }
    if(value>1000000){
        value = Math.floor((value/1000000)).toFixed(0);
        return '~ '+value + 'M';
    }
    if(value>1000){
        value = Math.floor((value/1000)).toFixed(0);
        return value + 'K';
    }
    return value.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
})

Vue.filter('dd-mm-yyyy', function(value) {
    return helper.formatDate(new Date(value * 1000), 'dd/mm/yyyy');
})
Vue.filter('mm-dd-yyyy', function(value) {
    return helper.formatDate(new Date(value * 1000), 'mm/dd/yyyy');
})
Vue.directive('debounce' , {
    bind(el, binding) {
        if(binding.value !== binding.oldValue) { 
            el.oninput = _.debounce(function (evt) {
                el.dispatchEvent(new Event('change'))
            }, parseInt(binding.value) || 500)
        }
    }
})
Vue.directive('tooltip', {
    bind: function (el, binding) {
        if( el != null && el != undefined){
            $(el).tooltip({
                trigger: "hover",
                placement: 'top'
            });
        }
    },
    unbind(el) {
        $(el).tooltip('destroy');
    }
})
Vue.directive('select', {
    twoWay: true,
    bind(el, binding, vnode) {
        var vm = this;
        $(el).on("select2:select", function(e) {
            var event = new Event('change', {
                bubbles: true
            })
            var value = $(el).select2("val");
            el.value = value;
            if ($(el).attr('create') != undefined && $(el).val() == '-1') {
                el.value = null;
                var addnew = $($(el).attr('create'));
                var modal = $(addnew).data('modal');
                modal = (modal == undefined) ? '#myModal' : modal;
                var a = document.createElement('a');
                var att = document.createAttribute("data-url");
                att.value = $(addnew).data('url');
                a.setAttributeNode(att);
                load_data_to_modal(a, modal);
            }
            el.dispatchEvent(event);
        });
    },
    update(el, vnode) {
        $(el).val(vnode.value).trigger('change');
    },
    inserted(el, vnode) {
        var holder = $(el).attr('placeholder');
        var isMutiple = $(el).attr('multiple');
        var notfound = $(el).attr('notfound');
        var create = $(el).attr('create');
        var noSearch = $(el).attr('no-search');
        var options = {}
        if (noSearch != undefined) {
            options['dropdownCssClass'] = 'no-search';
        }
        if (holder != undefined) {
            options['placeholder'] = holder;
        }
        if (isMutiple != undefined) {
            options['tags'] = true;
        }
        if (notfound != undefined) {
            var string = notfound;
            options['language'] = {
                noResults: function() {
                    return string;
                }
            }
        } else {
            options['language'] = {
                noResults: function() {
                    return "Không tìm thấy !";
                }
            }
        }
        options['escapeMarkup'] = function(markup) {
            return markup;
        }
        if (vnode.value === undefined) {
            $(el).select2(options).val(null).trigger('change');
        } else {
            $(el).select2(options).val(vnode.value).trigger('change');
        }
    }
});



function updateFunction(el, binding) {
    var options = {
        allowClear: true,
        multiple: true,
        tags: true,
    }
    var holder = $(el).attr('placeholder');
    if (holder != undefined) {
        options['placeholder'] = holder;
    }
    var vm = this;
    $(el).select2(options).on("select2:select", function(e) {
        vm.$emit('input', $(this).val())
    });
}
Vue.directive('mutipleselect', {
    inserted: updateFunction,
    componentUpdated: updateFunction,
});
Vue.component('mutipleselect', {
    props: ['options', 'value', 'placeholder'],
    template: '<select><option></option><option v-for="item in list" :value="item.id" >{{item.text}}</option></select>',
    mounted: function() {
        this.init();
    },
    computed:{
        list(){
            if( this.options == undefined) return [];
            return this.options.map(function(item){
                var el = {};
                el['id'] = item.hasOwnProperty('id') ? item['id'] : ( item.hasOwnProperty('_id')? item['_id'] : '' );
                el['text'] = item.hasOwnProperty('text') ? item['text'] :  ( item.hasOwnProperty('name')? item['name'] : '' ) ;
                return el;
            })
        },
    },
    watch: {
        value: function(value) {
            $(this.$el).val(value).trigger('change');
        },
        options: function(options) {
            $(this.$el).select2('destroy');
            this.init();
        }
    },
    methods:{
        init(){
            var options = {
                allowClear: true,
                multiple: true,
                tags: true,
            }
            if (this.placeholder != undefined) {
                options['placeholder'] = this.placeholder;
            }
            var vm = this;
            $(this.$el)
                // init select2
                .select2(options)
                .val(this.value)
                .trigger('change')
                .on('change', function() {
                    vm.$emit('input', $(this).val())
                })
            }
        },
        destroyed: function() {
            $(this.$el).off().select2('destroy');
        }
    })
Vue.component('select2Multiple', {
  props: ['options', 'value'],
  template: '<select><option></option><option v-for="item in list" :value="item.id" >{{item.text}}</option></select>',
  mounted: function () {
    var vm = this
    $(this.$el)
      // init select2
      .select2({ data: this.options })
      .val(this.value)
      .trigger('change')
      // emit event on change.
      .on('change', function () {
        vm.$emit('input', $(this).val())
    })
  },
  watch: {
    value: function (value) {
       if ([...value].sort().join(",") !== [...$(this.$el).val()].sort().join(","))
        $(this.$el).val(value).trigger('change');
},
options: function (options) {
      // update options
      $(this.$el).select2({ data: options })
  }
},
destroyed: function () {
    $(this.$el).off().select2('destroy')
}
})

// Vue.directive('datepicker', {
//     bind: function(el, binding, vnode) {
//         var options = {
//             dateFormat: "dd-mm-yy",
//             changeYear: true,
//             changeMonth: true,
//             yearRange: '1950:2050',
//             onSelect: function(date,i) {
//                 if(date !== i.lastVal){
//                     var date = helper.toDateTime(date) / 1000;
//                     var event = new Event('input', {
//                         bubbles: true
//                     })
//                     el.value = date;
//                     el.dispatchEvent(event);
//                 }
//             }
//         }

//         var minDate = $(el).attr('min');
//         if (minDate != undefined & maxDate != '') {
//             if (moment(new Date(minDate * 1000)).isValid()) {
//                 var date = moment(minDate * 1000).add(1 ,'days');
//                 options.minDate = new Date(date);
//             }
//         }
//         var maxDate = $(el).attr('max');
//         if (maxDate != undefined & maxDate != '') {
//             if (moment(new Date(maxDate * 1000)).isValid()) {
//                 var date = moment(maxDate * 1000).add(-1 ,'days');
//                 options.maxDate = new Date(date);
//             }
//         }
//         $(el).datepicker(options);
//     },
//     update: function(el, binding) {
//         if (el.value != '') {
//             var date = helper.formatDate(new Date(el.value * 1000), 'dd/mm/yyyy');
//             if (moment(new Date(el.value * 1000)).isValid()) {
//                 $(el).datepicker('setDate', new Date(el.value * 1000));
//             }
//         }
//         var minDate = $(el).attr('min');
//         if (minDate != undefined & minDate != null) {
//             if (moment(new Date(minDate * 1000)).isValid()) {
//                 var date = moment(minDate * 1000).add(1 ,'days');
//                 $(el).datepicker("option", "minDate",new Date(date));
//             }
//         }
//         var maxDate = $(el).attr('max');
//         if (maxDate != undefined & maxDate != '') {
//             if (moment(new Date(maxDate * 1000)).isValid()) {
//                 var date = moment(maxDate * 1000).add(-1 ,'days');
//                 $(el).datepicker("option", "maxDate", new Date(date));
//             }
//         }
//     },
//     destroyed: function() {
//         $(this.$el).datepicker("destroy");
//     }
// });
Vue.component('datepicker', {
    template: '<input type="text" class="form-control"/>',
    props:{
        value : {

        },
        max : {

        },
        min : {

        }
    },
    mounted: function() {
        var options = {
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            yearRange: '1970:2050',
            // onClose: this.onClose
        }
        if(this.min != undefined && this.min != '' &&  _.isDate(new Date(this.min * 1000))) {
            var date = moment(this.min * 1000).add(1 ,'days');
            options.minDate = new Date(date);
        }
        if(this.max != undefined && this.max != '' && _.isDate(new Date(this.max * 1000))) {
            var date = moment(this.max * 1000).add(-1 ,'days');
            options.minDate = new Date(date);
        }
        $(this.$el).datepicker(options);
        
        if( this.value == null ){
            $(this.$el).datepicker('setDate' , this.value);
        }else{
            if(this.value != undefined && this.value != '' && _.isDate(new Date(this.value * 1000))) {
                $(this.$el).datepicker('setDate' , new Date(this.value * 1000) );
            }else{
                this.$emit('input', null);
            }    
        }
    },
    methods: {
        onClose(date) {
            this.$emit('input', helper.toDateTime(date) / 1000);
        },
    },
    watch :{
        'value': function(newval){
            if( newval == null ){
                $(this.$el).datepicker('setDate' , newval);
            }else{
                if(newval != undefined && newval != '' && _.isDate(new Date(newval * 1000))) {
                    $(this.$el).datepicker('setDate' , new Date(newval * 1000) );
                }else{
                    this.$emit('input', null);
                }    
            }
        },
        'min': function(newval){
            if(newval != undefined && newval != '' && _.isDate(new Date(newval * 1000))) {
                var date = moment(newval * 1000).add(1 ,'days');
                $(this.$el).datepicker('option' , 'minDate' ,new Date(date) );
            }
        },
        'max': function(newval){
            if(newval != undefined && newval != '' && _.isDate(new Date(newval * 1000))) {
                var date = moment(newval * 1000).add(-1 ,'days');
                $(this.$el).datepicker('option' , 'maxDate' ,new Date(date) );
            }
        },
    }
});
Vue.component('slide',{
    props: {
        active: Boolean,
        duration: {
            type: Number,
            default: 500
        },
        tag: String ,
    },
    render(h) {
        return h(
            this.tag == undefined ? 'div' : this.tag,
            {
                style: {
                    display:'none',
                },
                ref: 'container',
            },
            this.$slots.default
            )
    },
    mounted () {
        this.render();
    },
    watch: {
        active() {
            this.render();
        }
    },
    methods: {
        render () {
            if (this.active) {
                $(this.$refs.container).slideDown(this.duration);
            } else {
                $(this.$refs.container).slideUp(this.duration);
            }
        }
    }
});
Vue.component('timerange', {
    props: ['classname', 'compare', 'start', 'end', 'open'],
    template: '<input type="text" :class="classname"  class="daterange_input" readonly />',
    data() {
        return {
            startDate: this.start,
            endDate: this.end,
        }
    },
    mounted() {
        var vm = this;
        if (this.startDate != undefined) {
            this.startDate = new Date(this.startDate * 1000);
        } else {
            this.startDate = typeof vm.compare == 'undefined' ? moment().startOf('month') : moment().subtract(1, 'month').startOf('month');
        }
        if (this.endDate != undefined) {
            this.endDate = new Date(this.endDate * 1000);
        } else {
            this.endDate = typeof vm.compare == 'undefined' ? moment().endOf('month') : moment().subtract(1, 'month').endOf('month');
        }
        $(this.$el).daterangepicker({
            startDate: this.startDate,
            endDate: this.endDate,
            alwaysShowCalendars: true,
            timePicker: true,
            timePicker24Hour: true,
            opens: (this.open == undefined) ? 'left' : this.open,
            locale: {
                format: 'DD/MM/YYYY HH:mm'
            },
            ranges: {
                'Hôm nay': [moment(), moment()],
                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
        });
        $(this.$el).on('apply.daterangepicker', function(ev, picker) {
            var endDate = moment(picker.endDate.format('YYYY-MM-DD'), 'YYYY-MM-DD').toDate().getTime() / 1000;
            var startDate = moment(picker.startDate.format('YYYY-MM-DD'), 'YYYY-MM-DD').toDate().getTime() / 1000;
            vm.$emit('input', {
                'endDate': endDate,
                'startDate': startDate
            });
        });
    },
    watch: {
        'value': function(val) {

        }
    }
});
Vue.component('daterange', {
    props:{
        value : {

        },
        compare:{

        },
        open :{
            type : String,
            default : 'left',
        },
        start:{

        },
        end :{

        },
        drop:{
            type : String,
            default : 'down',
        },
        classname:{

        },
        time :{
            type :Boolean,
            default : false,
        },
        allownull:{
            type :Boolean,
            default: false,
        }
    },
    template: '<input type="text" v-model="val" :class="classname"  class="daterange_input" />',
    data() {
        return {
            startDate: null,
            endDate: null,
            val : '',
        }
    },
    mounted() {
        var vm = this;
        if( this.value.hasOwnProperty('startDate')){
            this.startDate = parseInt(this.value.startDate);
        }else{
            if( this.allownull ){
                this.startDate = null;
            }else{
                this.startDate = typeof vm.compare == 'undefined' ? moment().startOf('month') : moment().subtract(1, 'month').startOf('month');
            }
        }

        if( this.value.hasOwnProperty('endDate')){
            this.endDate = parseInt(this.value.endDate);
        }else{
            if( this.allownull ){
                this.endDate = null;
            }else{
                this.endDate = typeof vm.compare == 'undefined' ? moment().endOf('month') : moment().subtract(1, 'month').endOf('month');
            }
        }
        if(this.value.hasOwnProperty('endDate') && this.value.hasOwnProperty('startDate')){
            var string_start = '';
            var string_end = '';
            if( moment(parseInt(this.value.startDate)*1000).isValid() &&moment(parseInt(this.value.endDate)*1000) ){
                if( vm.time){
                    string_start = 'Từ : '+ moment(parseInt(this.value.startDate)*1000).format('HH:mm DD/MM/YYYY');
                    string_end = ' - Đến : ' + moment(parseInt(this.value.endDate)*1000).format('HH:mm DD/MM/YYYY');
                }else{
                    string_start = 'Từ : ' + moment(parseInt(this.value.startDate)*1000).format('DD/MM/YYYY');
                    string_end = ' - Đến : ' + moment(parseInt(this.value.endDate)*1000).format('DD/MM/YYYY');
                }
                this.val = string_start + string_end;
            }
            
        }
        var options = {
            alwaysShowCalendars: true,
            opens:this.open,
            drops: this.drop,
            timePicker: this.time,
            timePicker24Hour: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY'
            },
            ranges: {
                'Hôm nay': [moment().startOf('day'), moment().endOf('day')],
                'Hôm qua': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                '7 ngày trước': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                '30 ngày trước': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
        };
        if( this.startDate != '' && this.startDate != null){
            options['startDate'] =  this.startDate;
        }
        if( this.endDate != '' && this.endDate != null){
            options['endDate'] =  this.endDate;
        }
        $(this.$el).daterangepicker(options);
        $(this.$el).on('apply.daterangepicker', function(ev, picker) {
            var string = new Date(picker.startDate);
            var startDate = parseInt(picker.startDate / 1000);
            var endDate = parseInt(picker.endDate / 1000);
            var string_start = '';
            var string_end = '';
            if( vm.time){
                string_start = 'Từ : '+ moment(picker.startDate).format('HH:mm DD/MM/YYYY');
                string_end = ' - Đến : ' + moment(picker.endDate).format('HH:mm DD/MM/YYYY');
            }else{
                string_start = 'Từ : ' + moment(picker.startDate).format('DD/MM/YYYY');
                string_end = ' - Đến :' + moment(picker.endDate).format('DD/MM/YYYY');
            }
            vm.val = string_start + string_end;
            vm.$emit('input', {
                'endDate': endDate,
                'startDate': startDate
            });
        });
    },
});
    Vue.component('phone', {
        props: ['value', 'max', 'min', 'classname', "disabled"],
        template: '<input type="text" :class="classname" v-model="val" @keyup="onBlur" @blur="onChange" :disabled="disabled"/>',
        data() {
            return {
                val: parseInt(this.value),
            }
        },
        mounted() {
            if (this.min != undefined && parseInt(this.min) != 'NaN') {
                var min = parseInt(this.min.toString().replace(/,/g, ""));
                if (parseInt(String(this.val).replace(/,/g, "")) < min) {
                    this.val = min;
                }
            }
            if (this.max != undefined && parseInt(this.max) != 'NaN') {
                var max = parseInt(this.max.toString().replace(/,/g, ""));
                if (parseInt(String(this.val).replace(/,/g, "")) > max) {
                    this.val = max;
                }
            }
            this.val = parseInt(String(this.val).replace(/,/g, ""));
            this.val = String(this.val);
            this.$emit('input', this.val);
        },
        methods: {
            onBlur() {
                this.$emit('onchangeevent');
            },
            onChange() {
                this.$emit('onblurevent');
            },
        },
        watch: {
            'value': function(newval, oldval) {
                if (newval != oldval) {
                    this.val = newval;
                }
            },
        },
    });
    Vue.component('number', {
        props: ['value', 'max', 'min', 'classname', "disabled"],
        template: '<input type="text" :class="classname" v-model="val" @keyup="onBlur" @blur="onChange" :disabled="disabled"/>',
        data() {
            return {
                val: parseInt(this.value),
            }
        },
        mounted() {
            if (this.min != undefined && parseInt(this.min) != 'NaN') {
                var min = parseInt(this.min.toString().replace(/,/g, ""));
                if (parseInt(String(this.val).replace(/,/g, "")) < min) {
                    this.val = min;
                }
            }
            if (this.max != undefined && parseInt(this.max) != 'NaN') {
                var max = parseInt(this.max.toString().replace(/,/g, ""));
                if (parseInt(String(this.val).replace(/,/g, "")) > max) {
                    this.val = max;
                }
            }
            this.val = parseInt(String(this.val).replace(/,/g, ""));
            this.val = String(this.val);
            this.$emit('input', this.val);
        },
        methods: {
            onBlur() {
                this.$emit('onchangeevent');
            },
            onChange() {
                this.$emit('onblurevent');
            },
        },
        watch: {
            'val': function(newval, oldval) {
                if (newval != oldval) {

                    if (this.val == '' || this.val == 'NaN') {
                        this.$emit('input', this.val);
                        this.$emit('onchangeevent');
                        return;
                    }
                    if (this.min != undefined && parseInt(this.min) != 'NaN') {
                        var min = parseInt(this.min.toString().replace(/,/g, ""));
                        if (parseInt(String(this.val).replace(/,/g, "")) < min) {
                            this.val = min;
                            this.$emit('input', this.val);
                            this.$emit('onchangeevent');
                            return;
                        }
                    }
                    if (this.max != undefined && parseInt(this.max) != 'NaN') {
                        var max = parseInt(this.max.toString().replace(/,/g, ""));
                        if (parseInt(String(this.val).replace(/,/g, "")) > max) {
                            this.val = max;
                            this.$emit('input', this.val);
                            this.$emit('onchangeevent');
                            return;
                        }
                    }
                    this.val = parseInt(String(this.val).replace(/,/g, ""));
                    this.$emit('input', this.val);
                    this.$emit('onchangeevent');

                }
            },
            'value': function(newval, oldval) {
                if (newval != oldval) {
                    this.val = newval;
                // this.$emit('onchangeevent');
            }
        },
    },
});
    Vue.component('money', {
        props: ['value', 'max', 'min', 'classname', "disabled"],
        template: '<input type="text" :class="classname" v-model="val" @keyup="onBlur" @blur="onChange" :disabled="disabled"/>',
        data() {
            return {
                val: this.value,
            }
        },
        mounted() {
            if (this.val == '' || this.val == undefined || this.val == 'NaN') {
                if (this.min != undefined) {
                    this.val = this.min;
                } else {
                    this.val = 0;
                }
                this.$emit('input', this.val);
                return;
            }
            if (this.min != undefined && parseInt(this.min) != 'NaN') {
                var min = parseInt(this.min.toString().replace(/,/g, ""));
                if (parseInt(String(this.val).replace(/,/g, "")) < min) {
                    this.val = min;
                }
            }
            if (this.max != undefined && parseInt(this.max) != 'NaN') {
                var max = parseInt(this.max.toString().replace(/,/g, ""));
                if (parseInt(String(this.val).replace(/,/g, "")) > max) {
                    this.val = max;
                }
            }
            this.val = parseInt(String(this.val).replace(/,/g, ""));
            this.val = String(this.val).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.$emit('input', this.val);
        },
        methods: {
            onBlur() {
                this.$emit('onchangeevent');
            },
            onChange() {
                this.$emit('onblurevent');
            },
        },
        watch: {
            'val': function(newval, oldval) {
                if (newval != oldval) {

                    if (this.val == '' || this.val == 'NaN') {
                        if (this.min != undefined) {
                            this.val = this.min;
                        } else {
                            this.val = 0;
                        }
                        this.$emit('input', this.val);
                        this.$emit('onchangeevent');
                        return;
                    }
                    if (this.min != undefined && parseInt(this.min) != 'NaN') {
                        var min = parseInt(this.min.toString().replace(/,/g, ""));
                        if (parseInt(String(this.val).replace(/,/g, "")) < min) {
                            this.val = min;
                            this.$emit('input', this.val);
                            this.$emit('onchangeevent');
                            return;
                        }
                    }
                    if (this.max != undefined && parseInt(this.max) != 'NaN') {
                        var max = parseInt(this.max.toString().replace(/,/g, ""));
                        if (parseInt(String(this.val).replace(/,/g, "")) > max) {
                            this.val = max;
                            this.$emit('input', this.val);
                            this.$emit('onchangeevent');
                            return;
                        }
                    }
                    this.val = parseInt(String(this.val).replace(/,/g, ""));
                    this.val = String(this.val).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.$emit('input', this.val);
                    this.$emit('onchangeevent');

                }
            },
            'value': function(newval, oldval) {
                if (newval != oldval) {
                    this.val = newval;
                // this.$emit('onchangeevent');
            }
        },
    },
});
    Vue.directive('editor',{
        twoWay: true,
        bind: function(el) {
            var id  =el.id;
            if( id == undefined || id == null || id == ''){
                var idStrLen = 32;
                var idStr = (Math.floor((Math.random() * 25)) + 10).toString(36) + "_";
                idStr += (new Date()).getTime().toString(36) + "_";
                do {
                    idStr += (Math.floor((Math.random() * 35))).toString(36);
                } while (idStr.length < idStrLen);
                id = idStr;
                $(el).attr('id', id);
            }
            tinymce.init({
                path_absolute : "/",
                height: 400,
                selector: "#"+id ,
                force_p_newlines : false,
                plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
                ],
                image_advtab: true,
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                relative_urls: false,
                file_browser_callback : function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = '/laravel-filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    }else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file : cmsURL,
                        title : 'Filemanager',
                        width : x * 0.8,
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no"
                    });
                },
                target: el,
                setup: function(editor) {
                // when typing keyup event
                // editor.on('init', ()=>{
                //     tinyMCE.activeEditor.setContent(el.value);
                // });
                editor.on('keyup', (e) => {
                    var new_value = tinyMCE.activeEditor.getContent();
                    var event = new Event('input', {bubbles: true})
                    el.value = new_value;
                    el.dispatchEvent(event);
                });
                editor.on('change', function () {
                    tinyMCE.triggerSave();
                });
            }
        });
        },
    });
    Vue.directive('editor-custom',{
        twoWay: true,
        bind: function(el) {
            var id  =el.id;
            if( id == undefined || id == null || id == ''){
                var idStrLen = 32;
                var idStr = (Math.floor((Math.random() * 25)) + 10).toString(36) + "_";
                idStr += (new Date()).getTime().toString(36) + "_";
                do {
                    idStr += (Math.floor((Math.random() * 35))).toString(36);
                } while (idStr.length < idStrLen);
                id = idStr;
                $(el).attr('id', id);
            }
            tinymce.init({
                path_absolute : "/",
                height: 200,
                selector: "#"+id ,
                menubar: false,
                plugins: [],
                image_advtab: false,
                toolbar: "",
                relative_urls: false,
                file_browser_callback : function(field_name, url, type, win) {
                  var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                  var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                  var cmsURL = '/laravel-filemanager?field_name=' + field_name;
                  if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            },
            setup: function(editor) {
                // when typing keyup event
                // editor.on('init', ()=>{
                //     tinyMCE.activeEditor.setContent(el.value);
                // });
                editor.on('keyup', (e) => {
                    var new_value = tinyMCE.activeEditor.getContent();
                    var event = new Event('input', {bubbles: true})
                    el.value = new_value;
                    el.dispatchEvent(event);
                });
            }
        });
        },
    });
    Vue.component('select2', {
        props:{
            value : {
                required: true,
            },
            options : {
                type : Object,
                default : false,
            },
            placeholder :{
                type : String ,
            },
            notfound : {
                type :  String,
                default : 'Không tìm thấy !',
            },
            search :{
                type : Boolean,
                default : true,
            },
            multiple : {
                type : Boolean,
                default : false,
            },
            change:{
                type : Function,
            },
            allowclear:{
                type : Boolean,
                default : false,
            },
            max :{
                type : Number,
                default :10 ,
            },
            disabled :{
                type: Boolean ,
                default: false,
            },
            readonly:{
                type : Boolean,
                default : false,
            },
            position : {
                type : String,
                default : 'left'
            },
            icon : {
                type : String,
            },
            width : {
                type : String,
                default  : 'resolve'
            },
            labels: {
                type : Array,
            }
        },
        template : '<select class="form-control" ></select>',
        created: function(){
            this.convert();
            
        },
        mounted: function() {
            var vm =  this;
            var config = {
                disabled: this.disabled,
                multiple : this.multiple,
                minimumResultsForSearch: this.search ? 0 : -1 ,
                allowClear : this.allowclear,
                data : this.data,
                language: {
                    noResults: function(){
                        return vm.notfound;
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            };
            if( this.placeholder != undefined){
                config['placeholder'] = this.placeholder;
            }
            this.config = config;
            this.init();

        },

        data : function(){
            return {
                data : [],
                config : {},
                selected : this.value,
                select2 : null,
            }
        },
        methods:{
            convert : function(){
                var vm = this;
                var data = [];
                data = $.map(vm.options, function(value, key) {
                    var el = {};
                    el['id'] = key;
                    el['text'] = String(value);
                    return el;
                });
                vm.data = data;
            },
            init : function(){
                var vm = this;
                vm.config['data'] = vm.data;
                if( vm.placeholder != undefined && !vm.multiple){
                    $(vm.$el).append("<option></option>")
                }
                
                if( vm.multiple ){
                    vm.select2 = $(vm.$el).select2(vm.config).on('change', function(e){
                        vm.$emit('input',$(this).val() );
                        if( vm.change != undefined && typeof vm.change == 'function'){
                            vm.change();
                        }
                    });
                }else{
                    vm.select2 = $(vm.$el).select2(vm.config).on('select2:select', function(e){
                        vm.$emit('input', e.params.data.id);
                        if( vm.change != undefined && typeof vm.change == 'function'){
                            vm.change();
                        }
                    });
                }
            },
            destroy : function(){
                if( $(this.$el).data('select2')){
                    this.select2.select2('destroy');
                    $(this.$el).empty();
                    this.init();
                }
            },
        },
        watch:{
            'options' : function(newval){
                this.convert();
                this.destroy();
            },
            'value' : function(newval){
                this.select2.val(newval).trigger('change.select2');
            },
            'disabled' : function(newval){
                $(this.$el).attr('disabled' , newval);
            }
        },
        computed:{

        },
    })