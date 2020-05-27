<div class="row">
    <div class="col-sx-12 col-sm-3 col-md-3">
        <label class="control-label">
            Ảnh đại diện
        </label>
        <div class="text-center">
            <template v-if="form.img">
                <a class="remove-img" v-on:click="removeImg">
                    <i class="fa fa-times-circle fa-2x text-danger"></i>
                </a>
            </template>
            <img :src="form.img ? form.img : '/resources/uploadCroup.png' " v-on:click="setImg" class="img-responsive cursor">
        </div>
    </div>
    <div class="col-sx-12 col-sm-9 col-md-9">
        <div class="form-group">
            <label class="control-label" for="code">
                Tên danh mục: <span class="text-danger">*</span>
            </label>
            <input class="form-control" type="text" name="name" v-model="form.name" required="" placeholder="">
        </div>
        <div class="form-group">
            <label class="control-label" for="code">
                URL: <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <span class="input-group-addon">{{ URL::to('/') }}</span>
                <input id="alias" name="alias" v-model="form.alias" type="text" class="form-control">
            </div>
            <p style="margin-top:5px;">
                <span class="label label-danger">NOTE!</span>
                <span id="title-len"><span class="text-danger">URL không được trùng nhau và dễ hiểu</span></span>
            </p>
        </div>
    </div>
</div>