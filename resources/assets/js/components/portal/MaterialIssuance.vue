<template>
    <div>
        <h3 class="mb-4"><i class="fas fa-dolly"></i> Material Issuance</h3>
        <div class="row" id="list" v-bind:style="{display : display_list}">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header bg-info text-white"><strong>Inquire</strong></div>
                    <form id="inquiry-form" @submit.prevent="inquire()">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="production_date">Production Date</label>
                            <input type="date" class="form-control" name="production_date" id="production_date" @change="inquire()">
                        </div>

                        <div class="form-group">
                            <label for="production_line">Production Line</label>
                            <select class="form-control" name="production_line" id="production_line" @change="inquire()">
                                <option readonly selected value> -- List all Production Line -- </option>
                                <option v-for="(option, i) in production_lines" v-bind:key="i" v-bind:value="option.value">{{option.caption}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="registration">Registration</label>
                            <select class="form-control" name="registration" id="registration" @change="inquire()">
                                <option readonly selected value> -- List all Registration -- </option>
                                <option v-for="(option, i) in registrations" v-bind:key="i" v-bind:value="option.value">{{option.caption}}</option>
                            </select>
                        </div>
                    </div>
                    </form>
                    <div class="card-footer">
                        <button class="btn btn-info btn-block" @click="inquire()"><i class="fas fa-search"></i> Inquire</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="card-body m-0 p-1">
                    <div class="row">
                        <div class="col-sm">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item" v-bind:class="[{ disabled: !pagination.prev_page }]" @click="!!pagination.prev_page && inquire(pagination.prev_page)"><a class="page-link" href="#"><i class="fas fa-backward"></i></a></li>

                                    <li class="page-item disabled" v-if="pagination.total_rec"><a class="page-link" href="#" >Page {{pagination.curr_page}} of {{pagination.last_page}}</a></li>

                                    <li class="page-item disabled" v-else><a class="page-link" href="#">No Record Found</a></li>
                                    
                                    <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page }]"><a class="page-link" href="#" @click="!!pagination.next_page && inquire(pagination.next_page)"><i class="fas fa-forward"></i></a></li>
                                </ul>
                            </nav>
                        </div>

                        <div class="col-sm text-right">
                            <button class="btn btn-success" data-toggle="modal" data-target="#AddModal" @click="toggleForm()" v-if="role=='MH' || role=='sysadmin'"><i class="fa fa-plus"></i> Create Request</button>
                        </div>
                    </div>
                </div>
                <table class="table table-sm table-condensed table-striped">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>Date</th>
                        <th>Production Date</th>
                        <th>Line</th>
                        <th>Registration</th>
                        <th>MITS</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <td colspan="8" class="text-center table-warning">
                                <h4>Loading Data. Please Wait...</h4>
                            </td>
                        </tr>

                        <tr v-if="transactions.length == 0">
                            <td colspan="8" class="text-center">No record found</td>
                        </tr>
                        <tr v-for="(transaction, i) in transactions" v-bind:key="i" v-else>
                            <td>{{ pagination.first_rec + i }}</td>
                            <td>{{transaction.date}}</td>
                            <td>{{transaction.production_date}}</td>
                            <td>{{transaction.production_line}}</td>
                            <td>{{transaction.registration}}</td>
                            <td>{{transaction.mits_number}}</td>
                            <td>{{transaction.status}}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <div class="row p-2">
                    <div class="col-sm">
                        <p class="text-center">
                            Showing record {{pagination.first_rec}} to {{pagination.last_rec}} (Total Records: {{pagination.total_rec}})
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="form" v-bind:style="{display : display_form}">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">Request Details</div>
                    <div class="card-body">
                        <div class="form-row mb-2">
                            <div class="col-sm-4">Production Date</div>
                            <div class="col-sm-8">
                                <input type="date" name="production_date" id="production_date" class="form-control" v-model="transaction.production_date" @change="getLines">
                            </div>
                        </div>

                        <div class="form-row mb-2">
                            <div class="col-sm-4">Production Line</div>
                            <div class="col-sm-8">
                                <select class="form-control" name="production_line" id="production_line" v-model="transaction.production_line" @change="lineDetails">
                                    <option readonly selected value disabled> -- Select Production Line -- </option>
                                    <option v-for="(option, i) in production_lines" v-bind:key="i" v-bind:value="option.value">{{option.caption}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row mb-2">
                            <div class="col-sm-4">Registration</div>
                            <div class="col-sm-8">
                                <input type="text" name="registration" id="registration" class="form-control" v-model="transaction.registration" readonly>
                            </div>
                        </div>

                        <div class="form-row mb-2">
                            <div class="col-sm-4">Product Type</div>
                            <div class="col-sm-8">
                                <select class="form-control" name="product_type" id="product_type" v-model="transaction.product_type">
                                    <option readonly selected value disabled> -- Select Product Type -- </option>
                                    <option v-for="(option, i) in production_schedules" v-bind:key="i" v-bind:value="option.product_type">{{option.product_type}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row mb-2">
                            <div class="col-sm-4">MITS Number</div>
                            <div class="col-sm-8">
                                <input type="text" name="mits_number" id="mits_number" class="form-control" placeholder="Enter MITS Number here" v-model="transaction.mits_number">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm">
                                <button class="btn btn-success btn-block" :disabled="transaction.mits_number=='' || transaction.items.length == 0"><i class="fas fa-save"></i> Save</button>
                            </div>
                            <div class="col-sm">
                                <button class="btn btn-danger btn-block" @click="toggleForm()"><i class="fas fa-ban"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-row">
                                    <div class="col-sm">
                                        <input type="text" class="form-control" id="item-search" v-model="item_details.item_code" placeholder="Enter Part Number here then hit the TAB / ENTER Key" v-on:keyup.13="checkItem" v-on:focusout="checkItem">
                                    </div>
                                </div>

                                <div class="form-row mt-2 ml-2">
                                    <div class="col-sm">
                                        <span id="item_description">{{ !item_details ? "-" : item_details.item_desc }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" name="uofm" value="base" @change="changeUofm">
                                            &nbsp;&nbsp;&nbsp;Base Unit
                                        </div>
                                    </div>
                                    <input type="number" step=".00001" class="form-control" v-model="item_details.base_qty" placeholder="Enter quantity in base unit" :readonly="uofm!='base' || item_details.item_desc == '-'" @keyup="convertQty()">
                                </div>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" name="uofm" value="issue" @change="changeUofm">
                                            &nbsp;&nbsp;&nbsp;Issue Unit
                                        </div>
                                    </div>
                                    <input type="number" step=".00001" class="form-control" v-model="item_details.issue_qty" placeholder="Enter quantity in issuance unit" :readonly="uofm!='issue' || item_details.item_desc == '-'" @keyup="convertQty()">
                                </div>
                            </div>

                            <div class="col-sm-2 align-middle">
                                <button id="AddItem" class="btn btn-primary btn-block" @click="addItem()" :disabled="item_details.item_desc=='-' || item_details.base_qty == 0">Add Item</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">Requested Items ({{transaction.items.length}} Item/s)</div>
                    <div class="card-body">
                        <div class="row mb-2" v-for="(item,i) in transaction.items" v-bind:key="i">
                            <hr>
                            <div class="col-sm-6">
                                <div class="form-row">
                                    <div class="col-sm">
                                        <h3>{{item.item_code}}</h3>
                                    </div>
                                </div>

                                <div class="form-row mt-1">
                                    <div class="col-sm">
                                        <span id="item_description">{{ item.item_desc }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4" v-if="item.edit == false">
                                <div class="row mb-3">
                                    <div class="col-sm">
                                        Qty in Base Units ({{item.uofm_base}}): {{item.base_qty}} 
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        Qty in Issue Units ({{item.uofm_issue}}): {{item.issue_qty}} 
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4" v-else>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" v-bind:name="'uofm'+i" value="base" @change="editUofm">
                                            &nbsp;&nbsp;&nbsp;Base Unit
                                        </div>
                                    </div>
                                    <input type="number" step=".00001" class="form-control" v-model="item.base_qty" placeholder="Enter quantity in base unit" :readonly="edit_uofm!='base'" @keyup="convertQtyEdit(item)">
                                </div>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" v-bind:name="'uofm'+i" value="issue" @change="editUofm">
                                            &nbsp;&nbsp;&nbsp;Issue Unit
                                        </div>
                                    </div>
                                    <input type="number" step=".00001" class="form-control" v-model="item.issue_qty" placeholder="Enter quantity in issuance unit" :readonly="edit_uofm!='issue'" @keyup="convertQtyEdit(item)">
                                </div>
                            </div>

                            <div class="col-sm-2 text-center" v-if="item.edit == false">
                                <button class="btn btn-success" @click="editItem(item)"><i class="far fa-edit"></i></button>&nbsp;
                                <button class="btn btn-danger" @click="deleteItem(item)"><i class="far fa-trash-alt"></i></button>
                            </div>

                            <div class="col-sm-2 text-center" v-else>
                                <button class="btn btn-success" @click="updateItem(item)"><i class="fas fa-save"></i></button>&nbsp;
                                <button class="btn btn-danger" @click="cancelEdit(item)"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    mounted() {
        this.transaction.date = this.default_date;
        this.transaction.production_date = this.default_date;

        this.inquire();
    },
    data() {
        return {
            production_lines: [],
            production_schedules: [],
            registrations: [
                {
                    value: 'PEZA',
                    caption: 'PEZA'
                },
                {
                    value: 'BOI',
                    caption: 'BOI'
                }
            ],
            transactions: [],
            transaction: {
                date: '',
                production_date: '',
                production_line: '',
                registration: '',
                product_type: '',
                mits_number: '',
                items: []
            },
            item_details: {
                item_code: '',
                item_desc: '',
                uofm_base: '',
                uofm_issue: '',
                conv_issue: 0,
                base_qty: 0,
                issue_qty: 0
            },
            item_codes:[],
            uofm: '',
            edit_uofm: '',
            old_values: {
                base_qty: 0,
                issue_qty: 0
            },
            pagination: {},
            loading: false,
            display_list: "flex",
            display_form: "none"
        }
    },
    created() {
        
    },
    props: {
        columns: Array,
        role: String,
        default_date: String
    },
    methods: {
        getLines: function(event) {
            let vm = this;

            fetch('/api/prodline/withsched/' + this.transaction.production_date, {
                method: 'post',
                })
                .then(res => res.json())
                .then(data => {
                    let list = [];
                    $.each(data.data, function(i) {
                        list.push(this);
                    });
                    
                    vm.production_lines = list;
                })
                .catch(err => console.log(err));
        },
        inquire(page_url) {
            this.loading = true;

            let params = {};

            let p = $("#inquiry-form").serializeArray();
            let d = [];

            $.each(p, function(i) {
                if (this.value != "") {
                    d.push(this);
                }
            });

            params['parameters'] = d;
            
            fetch(page_url || '/api/mes/issuance/list', {
                method: 'post',
                body: JSON.stringify(params),
                headers: {
                    'content-type': 'application/json'
                }
                })
                .then(res => res.json())
                .then(res => {
                    let vm = this;
                    this.transactions = res.data;
                    vm.makePagination(res.next_page_url, res.prev_page_url, res.current_page, res.last_page, res.from, res.to, res.total);
                    this.loading = false;
                })
                .catch(err => console.log(err));
        },
        makePagination(next_page_url, prev_page_url, current_page, last_page, from, to, total) {
            let msg = total > 0 ? 'Showing ' + from + ' of ' + to + ' of ' + total + ' entries' : 'No records to show';

            let pagination = {
                next_page: next_page_url,
                prev_page: prev_page_url,
                curr_page: current_page,
                last_page: last_page,
                first_rec: from,
                last_rec: to,
                total_rec: total,
                message: msg
            }

            this.pagination = pagination;
        },
        toggleForm() {
            let temp = this.display_list;
            this.display_list = this.display_form;
            this.display_form = temp;
        },
        lineDetails: function(event) {
            let vm = this;

            fetch('/api/prodline/schedule/' + this.transaction.production_date + "/" + this.transaction.production_line, {
                method: 'post',
                })
                .then(res => res.json())
                .then(data => {
                    let list = [];
                    $.each(data.data, function(i) {
                        vm.transaction.registration = this.registration;
                        list.push(this);
                    });
                    
                    vm.production_schedules = list;
                })
                .catch(err => console.log(err));
        },
        // selectProduct: function(event) {
        //     this.transaction.product_type = event.target.value;
        // },
        checkItem: function(event) {
            let vm = this;

            fetch('/api/planning/bom/check/' + this.transaction.product_type + "/" + event.target.value, {
                method: 'post',
                })
                .then(res => res.json())
                .then(data => {
                    let id = vm.item_details;

                    if (data.data.length == 0) { 
                        alert("Part Number ["+event.target.value+"] does not exist on ["+vm.transaction.product_type+"] BOM.");
                                                
                        id.item_desc = '-';
                        id.uofm_base = '';
                        id.uofm_issue = '';
                        id.conv_issue = 0;
                    } else {
                        id.item_desc = data.data[0].item_desc;
                        id.uofm_base = data.data[0].uofm_base;
                        id.uofm_issue = data.data[0].uofm_issue;
                        id.conv_issue = data.data[0].conv_issue;
                    }

                    id.base_qty = 0;
                    id.issue_qty = 0;
                })
                .catch(err => console.log(err));
        },
        changeUofm: function(event) {
            this.uofm = event.target.value;
        },
        editUofm: function(event) {
            this.edit_uofm = event.target.value;
        }, 
        convertQty() {
            let id = this.item_details;

            if (this.uofm == 'base') {
                id.issue_qty = Math.ceil(id.base_qty / id.conv_issue);
            } else {
                id.base_qty = id.issue_qty * id.conv_issue;
            }
        }, 
        convertQtyEdit(row) {
            if (this.edit_uofm == 'base') {
                row.issue_qty = Math.ceil(row.base_qty / row.conv_issue);
            } else {
                row.base_qty = row.issue_qty * row.conv_issue;
            }
        },
        addItem() {
            if (this.item_codes.includes(this.item_details.item_code)) {
                alert('This item [' + this.item_details.item_code + '] is already added.')
            } else {
                let id = this.item_details;
                this.item_codes.push(id.item_code);

                let add = {};

                $.each(id, function(k,v) {
                    add[k] = v;
                });

                add['edit'] = false;

                this.transaction.items.push(add);
                
                id.item_code = '';
                id.item_desc = '-';
                id.uofm_base = '';
                id.uofm_issue = '';
                id.conv_issue = 0;
                id.base_qty = '';
                id.issue_qty = '';

                $("#item-search").focus();
            }
        },
        deleteItem(row) {
            this.item_codes.splice(row,1);
            this.transaction.items.splice(row,1);
        },
        editItem(row) {
            this.old_values.base_qty = row.base_qty;
            this.old_values.issue_qty = row.issue_qty;

            row.edit = true;
        },
        cancelEdit(row) {
            row.base_qty = this.old_values.base_qty;
            row.issue_qty = this.old_values.issue_qty;

            row.edit = false;
        },
        updateItem(row) {
            row.edit = false;
        },
        saveTransaction() {

        }
    }
}
</script>