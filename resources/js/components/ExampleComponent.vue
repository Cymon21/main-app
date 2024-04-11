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
                        <tr v-for="value in listofEmployee" :key="value.id">
                            <th scope="row">{{ value.id }}</th>
                            <td>{{ value.Firstname }}</td>
                            <td>{{ value.Lastname }}</td>
                            <td>{{ value.Email }}</td>
                            <td>{{ value.Country }}</td>
                            <td>
                                <div class="btn-actions">
                                    <button
                                        type="button"
                                        class="btn btn-info"
                                        @click="editEmployee(value)"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        @click="deleteEmployee(value.id)"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Form -->
        <div class="add-edit-user">
            <div class="title-crud">
                <h3>You can add and edit here</h3>
            </div>
            <div class="table-form">
                <Form ref="addRef" @submit="saveData()">
                    <div class="cont">
                        <div class="inputs">
                            <label
                                >Firstname
                                <span class="errormsg">*</span></label
                            >
                            <Field
                                name="Firstname"
                                type="text"
                                v-model="employee.Firstname"
                                placeholder="Firstname"
                                :rules="isRequired"
                            />
                            <ErrorMessage
                                class="errormsg"
                                name="Firstname"
                            ></ErrorMessage>
                        </div>
                        <div class="inputs">
                            <label
                                >Lastname <span class="errormsg">*</span></label
                            >
                            <Field
                                name="Lastname"
                                type="text"
                                v-model="employee.Lastname"
                                placeholder="Lastname"
                                :rules="isRequired"
                            />
                            <ErrorMessage
                                class="errormsg"
                                name="Lastname"
                            ></ErrorMessage>
                        </div>
                        <div class="inputs">
                            <label>Email <span class="errormsg">*</span></label>
                            <Field
                                name="Email"
                                type="email"
                                v-model="employee.Email"
                                placeholder="Email"
                                :rules="validateEmail"
                            />
                            <ErrorMessage
                                class="errormsg"
                                name="Email"
                            ></ErrorMessage>
                        </div>
                        <div class="inputs">
                            <label
                                >Country <span class="errormsg">*</span></label
                            >
                            <Field
                                name="Country"
                                type="text"
                                v-model="employee.Country"
                                placeholder="Country"
                                :rules="isRequired"
                            />
                            <ErrorMessage
                                class="errormsg"
                                name="Country"
                            ></ErrorMessage>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >
                        Save
                    </button>
                </Form>
            </div>
        </div>
    </div>
</template>

<script>
import { Form, Field, ErrorMessage } from "vee-validate";
import Swal from "sweetalert2";
import axios from "axios";
import ExampleComponent from '../../../vendor/laravel/ui/src/Presets/vue-stubs/ExampleComponent.vue';
export default {
    name: ExampleComponent,
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        return {
            employee: {
                Firstname: "",
                Lastname: "",
                Email: "",
                Country: "",
            },
            listofEmployee: [],
            editing: false,
            employee_id: null
        };
    },
    methods: {

    //form validation
        isRequired(value) {
            if (value && value.trim()) {
                return true;
            }
            return "This input field is required";
        },
        validateEmail(value) {
            if (!value) {
                return "This input field is required";
            }
            const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if (!regex.test(value)) {
                return "This field must be a valid email";
            }
            return true;
        },
        saveData() {
            // Create
            if (!this.editing) { 
                axios
                    .post("employee/create", this.employee)
                    .then((response) => {
                        this.listofEmployee.push(response.data.data);
                        this.$toast.success(
                            `Success!!! You have successfully added the data`,
                            {
                                position: "top-right",
                                duration: 3000,
                            }
                        );
                        this.$refs.addRef.resetForm();
                        this.fetchData();
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        this.$toast.error(`Something went wrong...`, {
                            position: "top-right",
                            duration: 3000,
                        });
                    });
            } else  {
                this.updateEmployee(this.employee_id);
                this.fetchData();
           
            }
            this.editing = false;
        },
        
        fetchData() {
            axios
                .get("employee/fetch")
                .then((response) => {
                    this.listofEmployee = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        updateEmployee(id) {
            axios.put('employee/'+id, this.employee)
                .then((response) => {
                    console.log(response);
                     let data = response.data.data;
                        this.employee.Firstname = data.Firstname;
                        this.employee.Lastname = data.Lastname;
                        this.employee.Email = data.Email;
                        this.employee.Country = data.Country;
                        this.setNullEmployee();
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        editEmployee(value) {
            this.employee_id = value.id;
            this.employee.Firstname = value.Firstname;
            this.employee.Lastname = value.Lastname;
            this.employee.Email = value.Email;
            this.employee.Country = value.Country;
            this.editing = true;
        },

        setNullEmployee() {
            this.employee_id = null;
            this.employee.Firstname = null;
            this.employee.Lastname = null;
            this.employee.Email = null;
            this.employee.Country = null;
            this.editing = false;
        },

        deleteEmployee(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((data) => {
                    if (data.isConfirmed) {
                        axios.delete("/employee/" + id).then((response) => {
                            Swal.fire(
                                "Remove!",
                                "Employee has been remove.",
                                "success"
                            );
                            this.fetchData();
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        icon: "error",
                        text: "Something went wrong!",
                    });
                });
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>

<style scoped>
.container-fluid {
    display: flex;
    flex-direction: row;
    width: 100%;
}
.container-fluid .content {
    margin-right: 10px;
}
.content,
.add-edit-user {
    display: flex;
    flex-direction: column;
    height: 85vh;
    background-color: white;
    border-radius: 10px;
    width: 70%;
    padding: 40px;
    filter: drop-shadow(-1px 2px 4px #e7e7e7);
}
.add-edit-user {
    width: 30%;
}
.container {
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
.table {
    padding: 5px;
    background-color: white;
}
.btn-actions {
    width: 100%;
}
.btn-actions button {
    border: none;
    border-radius: 4px;
    margin-left: 5px;
    color: white;
}
.table-form {
    display: flex !important;
    flex-direction: column;
}
.inputs {
    width: 100%;
    margin-bottom: 10px;
}
input {
    padding: 10px;
}
.inputs input {
    width: 100%;
    height: 40px;
    border-radius: 2px;
    border: none;
    filter: drop-shadow(-1px 1px 2px #e7e7e7);
}
.errormsg {
    color: red;
    font-size: 13px;
    margin-bottom: 3px;
}
</style>
