<template>
   <div class="allposts-wraper">

        <div class="crud-project-header"> 
            <div class="title">
                <h1> All Posts </h1>
            </div>

            <div class="crud-project-action">
                <div class="crud-search"> 
                    <el-input @keyup.enter.native="fetchPosts()" placeholder="search" v-model="search" size="small">
                        <el-button slot="append" icon="el-icon-search" @click="fetchPosts()"></el-button>
                    </el-input>
                </div>
                <div class="button-section">
                    <router-link :to="{path: 'add_new_post'}" class="el-button el-button--primary el-button--small" size="medium">
                        Add New Post
                    </router-link>
                </div>
            </div>
        </div>

        <el-table :data="tableData" border style="width: 100%;">

            <el-table-column label="ID" width="60">
                <template slot-scope="scope">
                    <p> {{scope.row.ID}} </p>
                </template>
            </el-table-column>
           
            <el-table-column  label="Title">
                <template slot-scope="scope">
                    <router-link :to="{path: '/edit_Post/'+ scope.row.ID, params:{id: scope.row.ID } }">
                        {{scope.row.post_title}}
                    </router-link>
                </template>
            </el-table-column>

            <el-table-column label="Description">
                <template slot-scope="scope"> 
                    <p> {{scope.row.post_content}} </p>
                </template>
            </el-table-column>
            <el-table-column label="ShortCode">
                <template slot-scope="scope"> 
                    <code class="shortcode">
                        [crud_project_post id="{{ scope.row.ID }}"]
                    </code>      
                </template>
            </el-table-column>

            <el-table-column prop="date" label="Date"> 
                <template slot-scope="scope">
                    <p> {{scope.row.post_date}}</p>
                </template>

            </el-table-column>



            <el-table-column label="Action"> 
                <template slot-scope="scope">
                    <router-link title="Edit" :to="{ path: '/edit_Post/'+ scope.row.ID,  params:{id: scope.row.ID } }" class="el-button el-button--primary is-circle">
                        <i class="el-icon-edit"></i>
                    </router-link>
                    <el-button type="success" icon="el-icon-edit" circle></el-button>
                    <el-button type="danger" icon="el-icon-delete" circle @click="showModal(scope.row)"></el-button>
                </template>
            </el-table-column>
        </el-table>
        
        <div class="crud-pagination">
            <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page.sync="page_number"
                :page-size="per_page"
                :page-sizes="pageSizes"
                layout="total, sizes, prev, pager, next"
                :total="total"
                :background="true"

            >
            </el-pagination>
        </div>

        <el-dialog
            title="Are You Sure, You want to delete this post?"
            :visible.sync="dialogVisible"
            width="30%"
        >
            <div class="modal_body">
                <p>All the data assoscilate with this post will be deleted</p>
                <p>You are deleting post id: <b>{{ activeID }}</b>. <br/>
                    Form Title: <b>  {{activeTitle}}  </b>
                </p>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="deletePost(activeID)">Confirm</el-button>
            </span>
        </el-dialog>       
                

   </div>
</template>



<script>
  export default {
    name:'AddNewPosts',

    data() {
      return {
        tableData: [],
        dialogVisible: false,
        activeID: null,
        activeTitle: "",
        search: '',
        total: 0,
        pageSizes: [10, 20, 30, 40, 50, 100, 200],
        per_page: 10,
        page_number: 1,

        // pagination
        currentPage1: 5,
        currentPage2: 5,
        currentPage3: 5,
        currentPage4: 4

      }
    },


    methods: {
        fetchPosts() {
            this.$adminGet({ 
                route: 'get_posts',
                per_page: this.per_page,
                page_number: this.page_number,
                search: this.search
            })
            .then(response => {
                this.tableData = response.data.posts;
                this.total     = response.data.total; 
                console.log(response.data);
            })
            .fail(error => {
                console.log(error);
                // this.$showAjaxError(error);
            })
                  
        },
        showModal(data){
            console.log(data);
            this.activeID = data.ID;
            this.activeTitle = data.post_title
            this.dialogVisible = true
            
        },
        deletePost(id){
            console.log(id);
          this.$adminPost({
              route: "delete_post",
              post_id: id
          })
          .then(response => {
            // this.$message.success(response.data.message);
             this.fetchPosts();
             this.dialogVisible = false;
             this.$notify({
                title: 'Congratulations!',
                message: 'Successfully Deleted',
                type: 'success'
             });
          })
          .fail(error => {
              console.log(error);
          })



        },

        // pagination
        handleSizeChange(val) {
            this.per_page = val;
            this.fetchPosts();
            console.log(`${val} items per page`);
        },
        handleCurrentChange(val) {
            this.page_number = val;
            this.fetchPosts();
            console.log(`current page: ${val}`);
        }
    },

    mounted() {
        console.log(this.search);
        this.fetchPosts();
    }



  }
</script>

<style scoped>
.crud-project-header{
    display: flex;
    justify-content: space-between;
    width: auto;
    border-bottom: 1px solid #e3e8ee;
    clear: both;
    overflow: hidden;
    margin: 0;
    padding: 5px 15px;
    background-color: #f7fafc;
    font-weight: bold;
    color: #697386;
}
        
.crud-project-action {
    display: flex;
    justify-content: center;
    align-items: center;
}

.crud-search{
    margin-right: 10px;
}
.crud-pagination{
 text-align: right;
 margin-top:20px   
}
.allposts-wraper{
    margin: 0 20px 0 0;
}
</style>