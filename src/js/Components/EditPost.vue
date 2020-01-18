<template>
    
    <div class="crud-project_editpost">

        <div class="header">
            <h1> Edit Post {{$route.params.id}}  </h1>
        </div>


        <el-row :gutter="20">
            <el-col :span="19">
                <el-input type="text" v-model="post.post_title"></el-input> <br/><br/>
                <el-input type="textarea" :rows="20" v-model="post.post_content"></el-input>
            </el-col>
             <el-col :span="4">
                 <div class="publish-options"> 
                      <el-button type="success" @click="updatePost()"> update </el-button>
                      <el-button type="primary"> Preview </el-button>
                 </div>

                 <div class="categories-options"> 
                      <!-- <el-divider>  <h3>Category </h3> </el-divider> -->
                     
                        <el-checkbox-group v-model="checkList">
                            <el-checkbox label="Option A"></el-checkbox>
                            <el-checkbox label="Option B"></el-checkbox>
                            <el-checkbox label="Option C"></el-checkbox>
                            <el-checkbox label="Option D"></el-checkbox>
                            <el-checkbox label="Option E"></el-checkbox>
                            <el-checkbox label="Option F"></el-checkbox>
                            <el-checkbox label="Option G"></el-checkbox>
                            <el-checkbox label="Option H"></el-checkbox>
                        </el-checkbox-group>
                 </div>



             </el-col>
        </el-row>



    </div>

</template>

<script>
export default {
    name: 'EditPosts',
   
    data(){
        return{
            post : [],
           
            checkList: ['selected and disabled','Option A'],
           
        }
    },


    methods:{
        
        fetchEditPost(){
            this.$adminGet({
                route: 'edit_post',
                post_id: this.$route.params.id
            })
            .then(response => {
                this.post = response.data.post;
                // console.log(this.$route.params.id);
            })
            .fail( error => {
                 console.log(error);
            })
        },


        updatePost(){

          // validate first
            if (!this.post.post_title) {
                this.$notify({
                    title: 'Error',
                    message: 'Please provide post title',
                    type: 'error'
                });
                //this.$message.error('Please provide post title');
                return;
            }
            this.$adminPost({
                route: 'update_post',
                post_id:  this.post.ID,
                post_title: this.post.post_title,
                post_content: this.post.post_content
            })
            .then(response => {
                // this.$message.success(response.data.message);
                this.$notify({
                    title: 'Success',
                    message: 'Post successfully updated',
                    type: 'success'
                });
            })
            .fail( error => {
                console.log(error);
            })
        }



    },

    mounted(){
        this.fetchEditPost();
    }


}
</script>


<style scoped>
    
    .heade{
        background: #ffff;
        padding: 10px 20px;
        margin-left: -20px;
        margin-right: -20px;;
    }
   .publish-options {
        background: #ffff;
        padding: 10px 10px 10px 30px;
   }
   .categories-options{
       background: #ffff;
       margin-top: 30px;
       padding: 10px 
   }

</style>