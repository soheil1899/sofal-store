<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست محصولات </h4>

        <input type="button" @click="addproduct" class="btn btn-success my-2" data-toggle="modal"
               data-target="#Modal" value="افزودن محصول جدید">
        <input type="button" @click="reloadPage" class="btn btn-dark my-2 mr-1" value="بازخوانی">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="5%">#</th>
                <th scope="col" width="25%">نام محصول</th>
                <th scope="col" width="10%">دسته بندی</th>
                <th scope="col" width="15%">قیمت</th>
                <th scope="col" width="10%">تخفیف</th>
                <th scope="col" width="10%">موجودی</th>
                <th scope="col" class="p-0" width="25%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in productlist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.faname}}</td>
                <td class="py-2">{{item.category.name}}</td>
                <td class="py-2">{{item.price}}</td>
                <td class="py-2">{{item.discount}}%</td>
                <td class="py-2">{{item.tedad}}</td>
                <td class="py-1 icons">
                    <i title="نقد و بررسی" class="fas fa-poll fa-2x m-1" style="color: #bb2f88;" @click="setnaghd(item.id, item.faname, item.naghd)"></i>

                    <a :href="'productcomment/'+item.id">
                        <i title="کامنت" class="far fa-envelope fa-2x m-1" style="color: #7241bb;"></i>
                    </a>
                    <i title="گالری تصاویر" class="far fa-images fa-2x m-1" style="color: #5BB760;" @click="showpic(item.id, item.faname, item.image, item.gallery)"></i>
                    <i title="ویژگی" class="fab fa-steam-square fa-2x m-1" style="color: #FF9201;" @click="getattrs(item.id, item.category.id, item.faname)"></i>
                    <i title="ویرایش" class="far fa-edit fa-2x m-1" style="color: #00B2C9;" data-toggle="modal" data-target="#Modal" @click="editproduct(item.id, item.faname, item.enname, item.category, item.guarantees, item.price, item.discount, item.colors, item.brand, item.publish, item.special)"></i>
                    <i title="حذف" class="fas fa-trash fa-2x m-1" style="color: #EB3E37;" @click="deleteproduct(item.id)"></i>
                </td>
            </tr>
            </tbody>
        </table>






        <!-- Add & Edit Modal -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش محصول'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن محصول جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="row">
                                <div class="col-12 col-lg-6 border-left">
                                    <div class="form-group ">
                                        <input type="text" v-model="product_faname" class="form-control" placeholder="نام فارسی" name="title">
                                    </div>
                                    <div class="form-group ">
                                        <input type="text" v-model="product_enname" id="english-text"
                                               placeholder="نام انگلیسی" class="form-control" name="title">
                                    </div>
                                    <div class="form-group ">
                                        <v-select v-model="category" :options="categories" label="parentname"
                                                  :clearable="false" placeholder="دسته بندی" style="direction: rtl"></v-select>
                                    </div>
                                    <div class="form-group ">
                                        <v-select v-model="colors_selected" :options="colors" label="name"
                                                  :multiple="true" :clearable="false" placeholder="رنگ" style="direction: rtl"></v-select>
                                    </div>
                                    <div class="form-group ">
                                        <v-select v-model="brand" :options="brands" label="name"
                                                  :clearable="false" placeholder="برند" style="direction: rtl"></v-select>
                                    </div>

                                </div>


                                <div class="col-12 col-lg-6">
                                    <div class="form-group ">
                                        <v-select v-model="selectedguarantees" :options="guarantees" label="label"
                                                  :multiple="true" :clearable="false" placeholder="گارانتی" style="direction: rtl"></v-select>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label style="line-height: 29px">قیمت:</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="number" v-model.number="price" class="form-control" placeholder="قیمت">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label style="line-height: 29px">درصد تخفیف:</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="number" v-model.number="discount" class="form-control" placeholder="درصد تخفیف">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <label style="line-height: 29px">تعداد:</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="number" v-model.number="tedad" class="form-control" placeholder="تعداد">
                                        </div>
                                    </div>
                                    <div class="form-group mb-1 mt-3">
                                        <input type="checkbox" @change="specialcheck" class="form-check-input publish-checkbox mr-2" v-model="publish">
                                        <label class="form-check-label pr-2 mt-1 mr-4">نمایش</label>

                                    </div>
                                    <div class="form-group mb-1 ">
                                        <input type="checkbox" class="form-check-input publish-checkbox mr-2" v-if="publish == true" v-model="special">
                                        <input type="checkbox" class="form-check-input publish-checkbox mr-2" v-else disabled v-model="special">
                                        <label class="form-check-label pr-2 mt-1 mr-4">پیشنهاد ویژه</label>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="saveproduct" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>






        <!-- SubAttr Modal -->
        <div class="modal fade" id="subAttr" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ویژگی های
                            {{product_faname}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form id="subattr-form">


                            <div class="form-group mb-1 mb-2 position-relative subattr" v-for="item in this.attrlist"
                                 :key="item.id">
                                <label class="col-form-label group-title px-3 mt-3">{{item.title}}</label>

                                <div class="row border-bottom mx-3 mt-1" v-for="attr in item.subattributes"
                                     :key="attr.id">
                                    <div class="col-3">
                                        <label class="col-form-label">{{attr.title}}:</label>
                                    </div>
                                    <div class="col-9">
                                        <v-select v-if="attr.attribute_values[0]" v-model="selected[attr.id]"
                                                  :options="attr.attribute_values"
                                                  @input="doSomething(attr.id)" :taggable="true"
                                                  label="value"></v-select>
                                        <input v-else type="text" v-model="selected[attr.id]"
                                               class="form-control english-text">
                                    </div>

                                </div>

                            </div>


                        </form>
                    </div>

                    <div class="modal-footer">

                        <button type="button" @click="savesubattrvalue" class="btn btn-success">ذخیره</button>
                        <button type="button" class="btn btn-secondary">بازخوانی</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
                    </div>
                </div>
            </div>
        </div>





        <!-- gallery Modal -->
        <div class="modal fade" id="gallery" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">گالری تصاویر
                            {{product_faname}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    تصویر اصلی محصول
                                </div>
                                <div class="col-4 icons">
                                    <button type="button" @click="browsefile1" class="btn btn-success btn-sm">
                                        انتخاب تصویر
                                    </button>
                                </div>
                                <input type="file" style="display: none" id="browse1" ref="image"
                                       @change="selectimage">
                            </div>
                            <div class="card-body p-2">
                                    <img :src="prooriginalimage">

                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    تصاویر مربوط به گالری
                                </div>
                                <div class="col-4 icons">
                                    <button type="button" @click="browsefile2" class="btn btn-success btn-sm">افزودن
                                        تصویر
                                    </button>
                                </div>
                                <input type="file" style="display: none" id="browse2" ref="gallery"
                                       @change="selectgallery">
                            </div>
                            <div class="card-body p-2 icons">
                                <div v-for="gallery in gallerylist" :key="gallery.id" class="m-1 float-right position-relative">
                                    <img :src="gallery.image">
                                    <i title="پاک کردن" @click="deletegalleryimage(gallery.id)"
                                       class="fas fa-trash position-absolute delete-filemanager"></i>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>
                    </div>
                </div>
            </div>
        </div>







        <!-- Naghd Modal -->
        <div class="modal fade" id="naghdmodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">نقد و بررسی محصول
{{product_faname}}
                        </h5>
                    </div>

                    <div class="modal-body row">

                        <div class="col-12 col-lg-9" style="direction: ltr">
                            <editor v-model="text" ref="editor"
                                    api-key="qc1sdre33bdx4lkj24aw4ffoeyx1rvbohr9ow2hzhjgfu2mi"
                                    :init="{plugins: 'wordcount','directionality': 'rtl','height':300}"></editor>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="card">
                                <div class="card-header row m-0 p-1 pt-2">
                                    <div class="col-8">
                                        مدیریت فایل
                                    </div>
                                    <div class="col-4 icons">
                                        <i @click="browsefile" class="fas fa-plus-square fa-2x"
                                           style="color: #5BB760"></i>
                                    </div>
                                    <input type="file" style="display: none" id="browse" ref="imagetext"
                                           @change="selecttextimage">
                                </div>
                                <div class="card-body p-2">
                                    <div v-for="file in filemanagerids" :key="file.id"
                                         class="m-1 float-right position-relative icons">
                                        <img :src="file.small" @click="selectImage(file.original)">
                                        <i title="پاک کردن" class="fas fa-trash position-absolute delete-filemanager"></i>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="savenaghd">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>




        <!-- error Modal -->
        <div class="modal fade mt-5" id="errormodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header" style="background: linear-gradient(#dc3434, #e88080);">
                        <h5 class="modal-title">
                            خطا
                        </h5>
                    </div>

                    <div class="modal-body">
                        {{errormessage}}
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" @click="closeforstore">بستن</button>
                    </div>
                </div>
            </div>
        </div>








    </div>


</template>

<script>

    import vSelect from 'vue-select';
    import Editor from '@tinymce/tinymce-vue';

    Vue.component('v-select', vSelect);

    export default {
        name: "ProductComponent",
        components: {
            'editor': Editor
        },
        data() {
            return {
                productlist: [],
                attrlist: [],
                category: null,
                categories: [],
                guarantees: [],
                selectedguarantees: [],
                colors: [],
                colors_selected: [],
                brands: [],
                brand: null,
                error: [],
                editflag: false,
                productid: null,
                product_faname: null,
                product_enname: null,
                selected: [],
                price: 0,
                discount: 0,
                tedad: 0,
                publish: false,
                special: false,

                prooriginalimage: null,
                gallerylist: [],

                text: '',
                filemanagerids: [],

                errormessage: null,
            }
        },

        methods: {
            closeforstore(){
                $('#errormodal').modal('hide');
                $('#Modal').modal('hide');
            },

            seencomment(id, proname){
                $('#commentmodal').modal('show');
                this.product_faname = proname;
            },

            browsefile() {
                document.getElementById("browse").click();
            },

            selectImage(original) {
                let Imagetag = '<img src="' + original + '" width="200px">';
                this.text += Imagetag;
            },

            selecttextimage() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.imagetext.files[0]);
                axios.post('/dashboard/savefile'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['small'] = '/media/filemanager/itemsmall_' + response.data + '.png';
                        newfile['original'] = '/media/filemanager/item_' + response.data + '.png';
                        that.filemanagerids.push(newfile);
                    });
            },

            setnaghd(id, faname, naghd){
                $('#naghdmodal').modal('show');
                this.product_faname = faname;
                this.productid = id;
                this.text = naghd;
            },

            savenaghd(){
                let that = this;
                let data = {
                    productid: this.productid,
                    naghd: this.text,
                };
                axios.post('/dashboard/savenaghd', data)
                    .then(function (response) {
                        $('#naghdmodal').modal('hide');
                        that.reloadPage();
                    });
            },

            browsefile1() {
                document.getElementById("browse1").click();
            },
            browsefile2() {
                document.getElementById("browse2").click();
            },

            selectimage() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.image.files[0]);
                formData.append('proid', this.productid);

                axios.post('/dashboard/saveproimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {

                        that.prooriginalimage = '/media/product/'+that.productid+'/medium.png?'+ response.data[0];
                    });
            },
            selectgallery() {

                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.gallery.files[0]);
                formData.append('proid', this.productid);

                axios.post('/dashboard/saveprogallery'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['id'] = response.data[1];
                        newfile['image'] = '/media/product/' + that.productid + '/gallery/small_' + response.data[0] + '.png';
                        that.gallerylist.push(newfile);
                    });
            },

            deletegalleryimage(id){
                let that = this;
                let data = {
                    galleryid: id,
                };
                axios.post('/dashboard/deleteprogallery', data)
                    .then(function (response) {
                        for (var i = 0; i < that.gallerylist.length; i++) {
                            if (that.gallerylist[i]['id'] == id) {
                                that.gallerylist.splice(i, 1);
                            }
                        }
                    });
            },

            showpic(id, proname, image){

                let that = this;

                let data = {
                    productid: id,
                };
                axios.post('/dashboard/getprogallery', data)
                    .then(function (response) {
                        for (var i=0; i<response.data.length; i++){
                            let newfile = [];
                            newfile['id'] = response.data[i]['id'];
                            newfile['image'] = '/media/product/' + id + '/gallery/small_' + response.data[i]['image'] + '.png';
                            that.gallerylist.push(newfile);
                        }
                    });

                this.prooriginalimage = null;
                this.gallerylist = [];
                this.product_faname = proname;
                if(image == true){
                    this.prooriginalimage = '/media/product/'+ id +'/medium.png';
                }
                this.productid = id;



                $('#gallery').modal('show');


            },

            specialcheck(){
                if(this.publish == false){
                    this.special = false;
                }
            },

            addproduct() {
                this.error = [];
                this.editflag = false;
                this.productid = null;
                this.category = null;
                this.selectedguarantees = [];
                this.product_faname = null;
                this.product_enname = null;
                this.brand = null;
                this.colors_selected = [];
                this.price = 0;
                this.discount = 0;
                this.publish = false;
                this.special = false;
            },

            editproduct(id, faname, enname, category, guarantees, price, discount, colors, brand, publish, special) {
                this.error = [];
                this.editflag = true;
                this.productid = id;
                this.product_faname = faname;
                this.product_enname = enname;
                this.brand = brand;
                this.colors_selected = colors;
                this.selectedguarantees = guarantees;
                this.price = price;
                this.discount = discount;
                this.publish = publish;
                this.special = special;
                for (var i=0; i<this.categories.length; i++){
                    if(category['id'] == this.categories[i]['id']){
                        this.category = this.categories[i];
                    }
                }
                var guaranteecounter = 0;

            },
            savesubattrvalue() {
                let that = this;
                let data = {
                    values: this.selected,
                    productid: this.productid,
                };
                axios.post('/dashboard/saveattrvalue', data)
                    .then(function (response) {
                        $('#subAttr').modal('hide');

                    });
            },

            doSomething(id) {
                var find = false;
                for (var i = 0; i < this.selected.length; i++) {
                    if (this.selected[i] != undefined) {
                        if (this.selected[i]['subattribute_id'] == id) {
                            find = true;
                        }
                    }
                }
                if (find == false) {
                    if (this.selected[id]['value']) {
                        this.selected[id]['subattribute_id'] = id;
                    }
                }

            },
            getattrs(id, catid, faname) {
                let that = this;
                this.product_faname = faname;
                this.productid = id;
                this.selected = [];
                let data = {
                    productid: id,
                    categoryid: catid,
                };
                axios.post('/dashboard/getattributes', data)
                    .then(function (response) {

                        that.attrlist = response.data[0][0]['group_attributes'];

                        for (var k = 0; k < response.data[1].length; k++) {
                            that.selected[response.data[1][k]['subattribute_id']] = response.data[1][k]['value'];
                        }

                        $('#subAttr').modal('show');

                    });
            },

            deleteproduct(id) {
                let that = this;
                let data = {
                    productid: id,
                };
                axios.post('/dashboard/deleteproduct', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },

            saveproduct() {
                let that = this;
                let categoryID = null;

                if (this.category == null) {
                    categoryID = null;
                } else {
                    categoryID = this.category.id;
                }

                let data = {
                    productid: this.productid,
                    categoryid: categoryID,
                    product_enname: this.product_enname,
                    product_faname: this.product_faname,
                    editflag: this.editflag,
                    publish: this.publish,
                    special: this.special,
                    price: this.price,
                    discount: this.discount,
                    colors: this.colors_selected,
                    guarantees: this.selectedguarantees,
                    brand: this.brand,
                    tedad: this.tedad,
                };
                axios.post('/dashboard/saveproduct', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.reloadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                    if (error.response.data.message){
                        that.errormessage = error.response.data.message;
                        $('#errormodal').modal('toggle');
                    }
                });
            },

            reloadPage() {
                let that = this;
                axios.post('/dashboard/getproducts')
                    .then(function (response) {
                        that.productlist = response.data[0];
                        that.categories = response.data[1];
                        that.colors = response.data[2];
                        that.brands = response.data[3];
                        that.guarantees = response.data[4];

                        that.filemanagerids = [];
                        for (var i = 0; i < response.data[5].length; i++) {
                            let newfile = [];
                            newfile['small'] = '/media/filemanager/itemsmall_' + response.data[5][i]['randomnum'] + '.png';
                            newfile['original'] = '/media/filemanager/item_' + response.data[5][i]['randomnum'] + '.png';
                            that.filemanagerids.push(newfile);
                        }
                    });
            },


        },

        mounted() {
            this.reloadPage();
        }


    }


</script>

<style scoped>


</style>