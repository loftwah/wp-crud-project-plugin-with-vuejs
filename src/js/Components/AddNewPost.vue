<template>
   <div class="crud-project_editpost">
        <div class="header">
            <h1> Add New Post </h1>
        </div>
        <el-row>
            <el-col :span="19" style="margin-right:40px">
                <el-input type="text" v-model="post_title"></el-input> <br/><br/>
                <el-input type="textarea" :rows="20" v-model="post_content"> </el-input>
            </el-col>
            <el-col :span="4">
                    <div class="publish-options"> 
                      <el-button type="success" @click="createPost()"> Publish </el-button>
                      <el-button type="primary"> Preview </el-button>
                    </div>
                    <div class="categories-options"> 
                      <el-divider>  <h3>Category </h3> </el-divider>
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
    name: 'AddNewPost',
    
    data(){
        return{
            checkList: ['selected and disabled','Option A'],
            post_title: "",
            post_content: ""
        }
    },

    methods: {
        createPost(){
            this.$adminPost({
                route: "create_post",
                post_title: this.post_title,
                post_content: this.post_content
            })
            .then(response => {
               this.$router.push({name: 'edit_post', params: {id: response.data.post_id}})
               this.$notify({
                    title: 'Success',
                    message: 'Post successfully Created',
                    type: 'success'
                });
                console.log(response.data.post_id);
            })
            .fail(error => {
                console.log(error);
            })
        }
    }

}
</script>


<style scoped>
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