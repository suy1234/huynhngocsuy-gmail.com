Vue.component('pagination', {
    // props: ['current', 'total'],
    props:{
        current : {

        },
        total :{

        },
        pageshow : {
            type : Number,
            default :5 ,
        }
    },
    template: `
    <ul class="justify-content-right twbs-default pagination pagination-rounded pagination-sm" v-if="total > 1">
        <li class="page-item first" :class="{disabled : page == 1}"  @click.stop.prevent="first">
        <a href="#" class="page-link btn-sm"><i class="fas fa-fast-backward"></i></a>
        </li>
        <li class="page-item prev" :class="{disabled : page == 1}" @click.stop.prevent="prev">
        <a href="#" class="page-link btn-sm"><i class="fas fa-backward"></i></a>
        </li>
        <li class="page-item"
        v-for="item in total" @click.stop.prevent="setPage(item)"
        v-if="show(item)"
        :class=" { active : item == current} "
        >
        <a href="#" class="page-link btn-sm">{{item}}</a>
        </li>
        <li class="page-item next" :class="{disabled : page == total}">
        <a href="#" class="page-link btn-sm" @click.stop.prevent="next"><i class="fas fa-forward"></i></a>
        </li>
        <li class="page-item last" :class="{disabled : page == total}" @click.stop.prevent="last">
        <a href="#" class="page-link btn-sm"><i class="fas fa-fast-forward"></i></a>
        </li>
    </ul>
    `,
    mounted: function() {
        var vm = this;
    },
    data: function() {
        return {
            page: (this.current) ? this.current : 1,
        };
    },
    methods: {
        setPage(index) {
            this.page = index;
        },
        show(index) {
            if (this.current <= 3) {
                if (index <= this.pageshow) {
                    return true;
                } else {
                    return false
                }
            } else if (this.current > this.total - 3) {
                if (index > this.total - this.pageshow) {
                    return true;
                } else {
                    return false
                }
            }
            return Math.abs(index - this.current) < 3;
        },
        prev() {
            if (this.page > 1) {
                this.page--;
            }
        },
        next() {
            if (this.page < this.total) {
                this.page++;
            }
        },
        first() {
            this.page = 1;
        },
        last() {
            this.page = this.total;
        }
    },
    watch: {
        'page': function(newval, oldval) {
            if (newval != oldval) {
                this.$emit('input', newval)
            }
        }
    }
});
function Helper() {
    var methods = this;
    
// kiem tra du lieu
	methods.isEmail = function(str) {
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return pattern.test(str); // returns a boolean
    }
    methods.isNumber = function(str) {
        var pattern = /^\d+$/;
        return pattern.test(str); // returns a boolean
    }

    methods.isPhone = function(str) {
        var pattern = /^[0-9]*$/;
        return pattern.test(str); // returns a boolean
    }
    methods.isPattern = function(pattern, str) {
        return pattern.test(str);
    }
    methods.isNotEmpty = function(str) {
        var pattern = /\S+/;
        return pattern.test(str);
    }
    methods.isFloat = function(str){
        var pattern = /^[+-]?\d+(\.\d+)?$/;
        return pattern.test(str);
    }
	// get token
    methods._token = function() {
            if ($('meta[name=csrf-token]').length) {
                var _token = $('meta[name=csrf-token]').attr('content');
                return (_token === undefined) ? null : _token;
            }
            return null;
        }
// http request
    methods.get = function(url, timeout = 15000) {
        var formData = new FormData;
        formData.append('_token', helper._token());
        var promise = $.ajax({
                type: 'GET',
                data: formData,
                url: url,
                contentType: false,
                processData: false,
                timeout: timeout,
            })
            .done(function(responseData, status, xhr) {
                // preconfigured logic for success
            })
            .fail(function(xhr, status, err) {
                //predetermined logic for unsuccessful request
            });
        return promise;
    }
    methods.languageCode=function(url, data, timeout = 15000){
        data.append('_token', methods._token());
        var promise = $.ajax({
                type: 'POST',
                data: data,
                url: url,
                contentType: false,
                processData: false,
                timeout: timeout,
            })
        return promise;
    }
    methods.post = function(url, data, timeout = 15000) {
        data.append('_token', methods._token());
        var promise = $.ajax({
                type: 'POST',
                data: data,
                url: url,
                contentType: false,
                processData: false,
                timeout: timeout,
            })
            .done(function(response, status, xhr) {
                // preconfigured logic for success
            })
            .fail(function(xhr, status, err) {
                //predetermined logic for unsuccessful request
            });
        return promise;
    }
	methods.showNotification = function(message, type = 'info', time = 5000) {
        $.notify({
            icon: '',
            message: message
        }, {
            type: type,
            timer: time,
            delay: 2000,
            newest_on_top: true,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutRight'
            },
        });
    }
	methods.confirmDialogMulti = function(title, content, color, btn_done, btn_done_class, btn_close, btn_close_class, callback,callback1){
        $.confirm({
            title: title,
            content:content,
            type: "red",
            draggable: false,
            theme: 'material',
            buttons: {
                ok: {
                    text:btn_done,
                    btnClass: (btn_done_class == '') ? 'btn-primary' : btn_done_class,
                    keys: ['enter'],
                    action: function() {
                        callback();
                    }
                },
                cancel: {
                    text: btn_close,
                    keys: ['esc'],
                    btnClass: (btn_close_class == '') ? 'btn-default' : btn_close_class,
                     action: function() {
                       callback1();
                    },
                }
            }
        });
    }
    methods.comfirmDialog = function(title, content, color, btn_done, btn_done_class, btn_close, btn_close_class, callback) {
        $.confirm({
            title: title,
            content: content,
            type: "red",
            draggable: false,
            theme: 'material',
            buttons: {
                ok: {
                    text: btn_done,
                    btnClass: btn_done_class,
                    keys: ['enter'],
                    action: function() {
                        callback();
                    }
                },
                cancel: {
                    text: btn_close,
                    keys: ['esc'],
                    btnClass: btn_close_class,
                }
            }
        });
    }
    return this;
}
var helper = new Helper();
//
Vue.filter('money', function(value) {
    return (value == undefined) ? '' :  value.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
})