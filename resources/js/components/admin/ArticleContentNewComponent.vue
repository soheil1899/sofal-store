<template>

    <div>
        <h4 class="admin-title py-3 px-4">
افزودن مطلب جدید
        </h4>
        <div class="card" v-if="articleadd">
            <div class="card-header row m-0 p-1 pt-2">
                <div class="col-8">
                    تصویر مطلب
                </div>
                <div class="col-4 icons">
                    <button type="button" @click="browsefile" class="btn btn-success btn-sm">
                        انتخاب تصویر
                    </button>
                </div>
                <input type="file" style="display: none" id="browse" ref="image"
                       @change="selectimage">
            </div>
            <div class="card-body p-2">
                <img :src="articleoriginalimage">
            </div>
        </div>

        <div class="card mt-2" id="add-card" v-else>
            <div class="card-header row m-0 px-3">
                <strong>
                اطلاعات مربوط به مطلب جدید
                </strong>

            </div>
            <div class="card-body row">
                <div class="col-12">
                    <error :error="error"></error>
                </div>

                <div class="col-12 col-lg-6">
                    <v-select v-model="groupselect" :options="groups" label="name" :clearable="false" style="width: 100%; display: inline-block; direction: rtl"
                              placeholder="یکی از گروه ها را انتخاب کنید"></v-select>
                    <input type="text" v-model="articletitle" class="form-control mt-2" placeholder="عنوان مطلب">
                    <textarea v-model="articledescription" class="form-control mt-2" placeholder="توضیحات مربوط به مطلب..." rows="4"></textarea>
                    <div class="input-group mt-2" style="direction: ltr">
                        <div class="input-group-prepend">
                            <div class="input-group-text">/</div>
                        </div>
                        <input type="url" v-model="articlelink" class="form-control" placeholder="لینک مطلب">
                    </div>
                    <textarea v-model="articlesource" class="form-control mt-2 mb-2 mb-lg-0" placeholder="منابع مطلب..." rows="3"></textarea>
                </div>
                <div class="col-12 col-lg-6">
                    <v-select :multiple="true" v-model="articlekeys" :taggable="true" :no-drop="true"
                              :clearable="false" placeholder="کلمات کلیدی" style="direction: rtl"></v-select>
                    <v-select :multiple="true" v-model="articletags" :options="tags" label="tag" :clearable="false" placeholder="تگ" style="margin-top: 7px;direction: rtl"></v-select>
                    <textarea v-model="articlesubtext" class="form-control mt-2" placeholder="متن کوتاه..." rows="9"></textarea>
                    <div class="form-group mt-1">
                        <input type="checkbox" v-model="articlepublish" class="form-check-input publish-checkbox mr-2">
                        <label class="form-check-label pr-2 mt-1 mr-4">نمایش</label>
                    </div>
                    <input type="button" @click="cuntinue" class="btn btn-primary float-left" value="ذخیره و ادامه">
                </div>

            </div>
        </div>

    </div>


</template>


<script>


    export default {
        name: "ArticleContentNewComponent",


        data() {
            return {

                error: [],

                groupselect: null,
                groups: [],
                tags: [],

                articletitle: null,
                articledescription: null,
                articlelink: null,
                articlesource: null,
                articlekeys: null,
                articletags: null,
                articlesubtext: null,
                articlepublish: false,
                mylink: null,

                articleoriginalimage:null,
                articleadd: false,
                articleid: null,

            }
        },


        methods: {
            browsefile() {
                document.getElementById("browse").click();
            },

            selectimage() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.image.files[0]);
                formData.append('articleid', this.articleid);

                axios.post('/dashboard/savearticleimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        window.location="http://127.0.0.1:8000/dashboard/articles/articles-content/"+that.articleid;
                    });
            },

            cuntinue(){
                let that = this;
                this.error = [];

                var groupid = null;
                if(this.groupselect != null){
                    groupid = this.groupselect['id'];
                }
                let data = {
                    editflag: false,

                    groupid: groupid,
                    articletitle: this.articletitle,
                    articleurl: this.articlelink,
                    minitext: this.articlesubtext,
                    articlereference: this.articlesource,
                    description: this.articledescription,
                    publish: this.articlepublish,
                    keywords: this.articlekeys,
                    tags: this.articletags,
                };

                axios.post('/dashboard/savearticle', data)
                    .then(function (response) {
                        that.articleid = response.data;
                        that.articleadd = true;
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });

            },


            loadPage() {
                let that = this;
                let data = {
                };

                axios.post('/dashboard/newcontentreload')
                    .then(function (response) {

                        that.groups = response.data[0];
                        that.tags = response.data[1];
                    });
            },

        },

        mounted() {
            this.loadPage();
        }


    }
</script>

<style scoped>

</style>