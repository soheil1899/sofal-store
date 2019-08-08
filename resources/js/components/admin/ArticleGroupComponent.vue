<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست گروه های مطالب </h4>

        <input type="button" @click="addgroup" class="btn btn-success my-2" data-toggle="modal"
               data-target="#Modal" value="افزودن گروه جدید">
        <input type="button"  class="btn btn-dark my-2 mr-1" value="بازخوانی">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="20%">نام گروه</th>
                <th scope="col" width="20%">عنوان گروه</th>
                <th scope="col" width="20%">آدرس</th>
                <th scope="col" class="p-0" width="30%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.articlelist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.name}}</td>
                <td class="py-2">{{item.title}}</td>
                <td class="py-2" style="direction: ltr">{{item.url}}</td>
                <td class="py-1 icons">
                    <a :href="'articles/'+item.id">
                        <i title="مطالب" class="fas fa-stream fa-2x m-1" style="color: #5BB760;"></i>
                    </a>
                    <i title="ویرایش" class="far fa-edit fa-2x m-1" style="color: #00B2C9;" @click="editgroup(item.id, item.name, item.title, item.url, item.description, item.keywords)" data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" class="fas fa-trash fa-2x m-1" style="color: #EB3E37;"></i>
                </td>
            </tr>
            </tbody>
        </table>



        <!-- Add & Edit Modal -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش گروه'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن گروه جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>
                       
                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="groupname" class="form-control" placeholder="نام گروه">
                            </div>
                            <div class="form-group mb-1">
                                <input type="text" v-model="grouptitle" class="form-control" placeholder="عنوان گروه">
                            </div>
                            <div class="form-group mb-1">
                                <div class="input-group" style="direction: ltr">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">/</div>
                                    </div>
                                    <input type="url" v-model="groupurl" class="form-control" placeholder="آدرس گروه">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <textarea v-model="description" class="form-control" rows="3" placeholder="توضیحات..."></textarea>
                            </div>
                            <div class="form-group mb-1">
                                <v-select v-model="keywords" placeholder="کلمات کلیدی..." :multiple="true" :taggable="true" :no-drop="true" :clearable="false"></v-select>
                            </div>

                            
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savegroup" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


        

    </div>


</template>

<script>

    export default {
        name: "ArticleGroupComponent",
        data() {
            return {
                editflag: false,
                articlelist: [],
                groupname: null,
                grouptitle: null,
                groupurl: null,
                description: null,
                keywords: [],
                error: [],
                groupid: null,
            }
        },

        methods: {

            reloadPage(){
                let that = this;
                axios.post('/dashboard/getarticlegroups')
                    .then(function (response) {
                        that.articlelist = response.data;
                    });
            },

            addgroup(){
                this.error = [];
                this.editflag = false;
                this.groupname = null;
                this.grouptitle = null;
                this.groupurl = null;
                this.description = null;
                this.keywords = [];
                this.groupid = null;
            },

            editgroup(id, name, title, url, description, keywords){
                this.error = [];
                this.editflag = true;
                this.groupname = name;
                this.grouptitle = title;
                this.groupurl = url;
                this.description = description;
                this.groupid = id;
                this.keywords = [];
                if(keywords.length > 0){
                    for (var i=0; i<keywords.length; i++){
                        this.keywords.push(keywords[i]['keyword']);
                    }
                }
            },

            savegroup(){
                let that = this;
                let data = {
                    editflag: this.editflag,
                    groupid: this.groupid,
                    groupname: this.groupname,
                    grouptitle: this.grouptitle,
                    groupurl: this.groupurl,
                    description: this.description,
                    keywords: this.keywords,
                };
                axios.post('/dashboard/savegroup', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.reloadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });
            },
            //
            // deletecolor(id){
            //     let that = this;
            //     let data = {
            //         id: id,
            //     };
            //     axios.post('/dashboard/deletecolor', data)
            //         .then(function (response) {
            //             that.reloadPage();
            //         })
            // },
            
        },

        mounted() {
            this.reloadPage();
        }


    }
</script>

<style scoped>

</style>