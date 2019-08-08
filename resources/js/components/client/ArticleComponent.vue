<template>
    <div class="container pt-5 pb-5">

        <div class="row pb-4 border-bottom mb-3" v-for="item in articles" :key="item.id">
            <div class="col-12 col-md-4">
                <img class="article-img" :src="createimagelink(item.id, item.image)" width="100%">
            </div>
            <div class="col-12 col-md-8">
                <div class="row mb-1 mt-3 mt-lg-0">
                    <div class="col-12 col-lg-5">
                        <h4><strong>
                            {{item.title}}
                        </strong></h4>
                    </div>
                    <div class="col-12 col-lg-7 text-lg-left">
                        <small><em>
                            نویسنده:
                             {{item.user.userinfo.firstname +' '+ item.user.userinfo.lastname}}
                            -
                            {{item.date}}
                        </em></small>
                    </div>
                </div>
                <p class="my-1">
                    {{item.minitext}}
                </p>
                <a class="py-1 px-2 btn btn-outline-dark btn-sm float-left" href="#"><small>ادامه مطلب...</small></a>
            </div>
        </div>


    </div>
</template>

<script>
    import moment from 'jalali-moment';

    export default {
        name: "ArticleComponent",

        data(){
            return{
                articles: [],
            }
        },

        methods:{

            createimagelink(id, image){
                if(image == true){
                    return '/media/article/'+id+'_large.png';
                }
            },

            loadpage(){
                let that = this;
                axios.post('/getarticles')
                    .then(function (response) {
                        that.articles = response.data;
                        for (var i = 0; i < that.articles.length; i++) {
                            that.articles[i]['date'] = moment((that.articles[i]['created_at']).slice(0, 10), 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD');
                        }
                        console.log(response.data);
                    });
            }
        },

        mounted() {
            this.loadpage();
        }


    }
</script>

<style scoped>

</style>