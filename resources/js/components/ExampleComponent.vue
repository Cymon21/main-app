<template>
    <div class="container-fluid">
        <div class="content">
            <div class="title-crud">
                <h3>Employee List</h3>
                <!-- <button type="button" class="btn btn-primary btn-sm ml-auto" @click="openAddModal">Add</button> -->
            </div>
            <div class="table">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Country</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>Otto@gmail.com</td>
                            <td>Philippines</td>
                            <td>
                                <div class="btn-actions">
                                    <button type="button" class="btn btn-info">Edit</button>
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- for showing modal -->
               <!-- <AlertModalVue v-if="showModal" @click="closeModal"></AlertModalVue> -->
            </div>
        </div>
        <div class="add-edit-user">
            <div class="title-crud">
                <h3>User can add and edit here</h3>
            </div>
            <div class="table-form">
                <form @submit.prevent="saveData()">
                    <div class="cont">
                        <div class="inputs">
                            <label>Firstname <span class="errormsg">*</span></label>
                            <input type="text" v-model="employee.Firstname" name="Firstname" placeholder="Firstname" />
                            <!-- <ErrorMessage name="Firstname" class="errormsg" /> -->
                        </div>
                        <div class="inputs">
                            <label>Lastname <span class="errormsg">*</span></label>
                            <input type="text" v-model="employee.Lastname" name="Lastname" placeholder="Lastname"/>
                            <!-- <ErrorMessage name="Lastname" class="errormsg" /> -->
                        </div>
                        <div class="inputs">
                            <label>Email <span class="errormsg">*</span></label>
                            <input type="email" v-model="employee.Email" name="Email"  placeholder="Email"/>
                            <!-- <ErrorMessage name="Email" class="errormsg" /> -->
                        </div>
                        <div class="inputs">
                            <label>Country <span class="errormsg">*</span></label>
                            <input type="text" v-model="employee.Country" name="Country"  placeholder="Country"/>
                            <!-- <ErrorMessage name="Country" class="errormsg" /> -->
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Save</button> 
                </form>
            </div>
        </div>
    </div>
</template>


<!-- <script>
import AlertModalVue from './AlertModal.vue';
export default {
    name: 'ExampleComponent',
    components: {
        AlertModalVue,
    },
    data() {
        return {
            showModal: false,
        };
    },
    methods: {
        openAddModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
    },
    mounted() {
        console.log("Component mounted.");
    },  
};
</script> -->


<script>
// import { Form, Field, ErrorMessage } from 'vee-validate';
export default {
    // components: {
    //     Form,
    //     Field,
    //     ErrorMessage
    // },
    data(){
        return{
            'employee': {
                'Firstname':'',
                'Lastname':'',
                'Email':'',
                'Country':'',
            }
        }
    },
    methods : {
        saveData(){
            // console.log("Testing", this.employee)
            axios.post('/employee/create', this.employee).then(
                response => {
                    console.log(response);
                    // this.$toast.success(`Success!!! You have successfully add the data`, {
                    //     position: "top-right",
                    //     duration: 3000,
                    // });
                }
            ).catch(error => {
                console.log(error);
                // this.$toast.error(`Something went wrong...`, {
                //     position: "top-right",
                //     duration: 3000,
                // });
            })
        },
        // isRequired(value){
        //     if (value && value.trim()) {
        //         return true;
        //     }
        //     return 'This is required';
        // },
        // validateEmail(value) {
        //     if (!value) {
        //         return 'This field is required';
        //     }
        //     const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        //     if (!regex.test(value)) {
        //         return 'This field must be a valid email';
        //     }
        //     return true;
        // },
    },
    mounted() {
        console.log("Component mounted.");
    },
}
</script>




<style scoped>
.container-fluid {
    display: flex;
    flex-direction: row;
    width: 100%;
}
.container-fluid .content{
    margin-right: 10px;
}
.content,
.add-edit-user{
    display: flex;
    flex-direction: column;
    height: 85vh;
    background-color: white;
    border-radius: 10px;
    width: 70%;
    padding: 40px;
    filter: drop-shadow(-1px 2px 4px #e7e7e7);
}
.add-edit-user{
    width: 30%;
}
.container{
    flex-direction: column;
}
.title-crud {
   display: flex;
   width: 100%;
   justify-content: space-between;
   align-items: center;
   padding: 2px;
   margin-bottom: 10px;
}

.title-crud h3 {
    font-size: 20px;
    font-weight: 600;
}
.table{
    padding: 5px;
    background-color: white;
}
.btn-actions{
    width: 100%;
}
.btn-actions button{
    border: none;
    border-radius: 4px;
    margin-left: 5px;
    color: white;
}
.table-form{
    display: flex  !important;
    flex-direction: column;
}
.inputs{
    width: 100%;
}
input{
    padding: 10px;
}
.inputs input{
    width: 100%;
    height: 40px;
    border-radius: 2px;
    border: none;
    filter: drop-shadow(-1px 1px 2px #e7e7e7);
    margin-bottom: 10px;
}
.errormsg{
    color: red;
    font-size: 13px;
}
</style>
