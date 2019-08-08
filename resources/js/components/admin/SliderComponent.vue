<template>
    <div>
        <h4 class="admin-title py-3 px-4"> مدیریت اسلایدر </h4>
        <input type="button" class="btn btn-success my-2" @click="addslider" data-toggle="modal" data-target="#addModal" value="افزودن اسلایدر جدید">


        <div class="card mt-2" v-for="slider in sliderlist" :key="slider.id" >
            <div class="card-header row m-0 px-1">
                <div class="col-6">
                    {{slider.title}}
                </div>
                <div class="col-6 icons">
                    <i title="ویرایش" style="color: #00B2C9;" @click="editslider(slider.id, slider.images, slider.title)"
                       class="fas fa-edit ml-2 fa-lg"></i>
                    <i title="حذف" style="color: #EB3E37;" @click="deleteslider(slider.id)" class="fas fa-trash ml-3 fa-lg"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="m-1 float-right position-relative" v-for="image in slider.images" :key="image.id">
                    <img :src="createsliderurl(image.image, slider.id)">
                </div>
            </div>
        </div>








        <!-- Add & Edit Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">افزودن اسلایدر جدید</h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>
                        <div class="form-group ">
                            <input type="text" class="form-control" v-model="slidertitle" placeholder="عنوان اسلایدر" name="title">
                        </div>
                        <div class="card" v-if="slidertitle != null && slidertitle != ''">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    تصاویر مربوط به اسلایدر: {{slidertitle}}
                                </div>
                                <div class="col-4 icons">
                                    <button type="button" @click="browsefile" class="btn btn-success btn-sm">افزودن
                                        تصویر
                                    </button>
                                </div>
                                <input type="file" style="display: none" id="browse" ref="slider"
                                       @change="selectgallery">
                            </div>
                            <div class="card-body p-2">
                                <div v-for="image in imagelist" :key="image.id"
                                     class="m-1 float-right position-relative">
                                    <img :src="createsliderurl(image.image, image.slider_id)">
                                    <i @click="deletesliderimage(image.id)"
                                       class="fas fa-trash position-absolute delete-filemanager"></i>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeslidermodal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>




<script>
    export default {
        name: "SliderComponent",

        data() {
            return {
                error: [],
                sliderlist: [],
                slidertitle: null,
                editflag: false,
                sliderid: null,
                imagelist: [],
            }
        },

        methods: {

            deleteslider(id){
                let that = this;
                let data = {
                    id: id,
                };

                axios.post('/dashboard/deleteslider', data)
                    .then(function (response) {
                        that.reloadpage();

                    });
            },

            editslider(id, images, title){
                this.sliderid = id;
                this.imagelist = images;
                this.slidertitle = title;
                $('#addModal').modal('show');
            },

            createsliderurl(image, sliderid) {
                return '/media/slider/'+ sliderid +'/small_' + image + '.png';
            },

            reloadpage() {
                let that = this;
                axios.post('/dashboard/getslider')
                    .then(function (response) {
                        that.sliderlist = response.data;
                    });
            },


            browsefile() {
                document.getElementById("browse").click();
            },

            selectgallery() {
                let that = this;
                let formData = new FormData();
                formData.append('title', this.slidertitle);
                formData.append('image', this.$refs.slider.files[0]);
                formData.append('editflag', this.editflag);
                formData.append('sliderid', this.sliderid);

                axios.post('/dashboard/savesliderimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['slider_id'] = response.data[0];
                        that.sliderid = response.data[0];
                        newfile['image'] = response.data[1];
                        newfile['id'] = response.data[2];
                        newfile['title'] = null;
                        newfile['link'] = null;
                        newfile['subtext'] = null;

                        that.imagelist.push(newfile);


                    });
            },
            addslider(){
                this.error = [];
                this.sliderid = null;
                this.slidertitle = null;
                this.imagelist = [];

            },

            closeslidermodal(){
                this.reloadpage();
                $('#addModal').modal('toggle');

            },


            deletesliderimage(id) {
                let that = this;
                let data = {
                    id: id,
                };

                axios.post('/dashboard/deletesliderimage', data)
                    .then(function (response) {

                        for (var i = 0; i < that.imagelist.length; i++) {
                            if (that.imagelist[i]['id'] == id) {
                                that.imagelist.splice(i, 1);
                            }
                        }

                    });

            },
        },

        mounted() {
            this.reloadpage();
        }

    }
</script>

<style scoped>

</style>