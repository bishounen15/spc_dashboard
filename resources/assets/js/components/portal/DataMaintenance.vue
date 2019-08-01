<template>
    <div>
        <h3 class="mb-4"><i v-bind:class="icon"></i> {{title}}</h3>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header bg-info text-white"><strong>Inquire</strong></div>
                    <div class="card-body">
                        <div class="form-group" v-for="(column, i) in columns" v-bind:key="i">
                            <div v-if="column.inquire">
                                <label v-bind:for="column.name">{{column.display_name}}</label>

                                <select v-bind:name="column.name" v-bind:id="column.name" class="form-control form-control-sm" v-if="column.type=='select'">
                                    <option readonly selected value> -- List all {{column.display_name}} -- </option>
                                    <option v-for="(option, i) in droplists[column.name]" v-bind:key="i" v-bind:value="option.value">{{option.caption}}</option>
                                </select>
                                
                                <input v-bind:type="column.type" class="form-control form-control-sm" v-bind:name="column.name" v-bind:id="column.name" v-on:keyup.13="inquire()" v-bind:placeholder="column.placeholder" v-bind:value="column.default_value" :readonly="column.read_only" v-else-if="column.default_value">

                                <input v-bind:type="column.type" class="form-control form-control-sm" v-bind:name="column.name" v-bind:id="column.name" v-model="inquire_data[column.name]" v-on:keyup.13="inquire()" v-bind:placeholder="column.placeholder" :readonly="column.read_only" v-else>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-info btn-block" @click="inquire()"><i class="fas fa-search"></i> Inquire</button>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-warning text-white"><strong>Record List</strong></div>
                    
                    <div class="card-body m-0 p-2">
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
                                <button class="btn btn-success" data-toggle="modal" data-target="#AddModal" @click="generateSeries()"><i class="fa fa-plus"></i> Add Record</button>
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#ImportModal"  v-if="xl_import"><i class="fas fa-file-excel"></i> Import from Excel</button>
                            </div>
                        </div>
                    </div>

                    <div style="overflow: auto;">
                        <table class="table table-condensed table-striped table-hover table-sm">
                            <thead class="thead-dark">
                                <th width="5%">#</th>
                                <th v-for="(column, i) in table_columns" v-bind:key="i" v-bind:width="column.width">{{column.display_name}}</th>
                                <th width="10%" class="text-center">Actions</th>
                            </thead>
                            <tbody>
                                <tr v-if="loading">
                                    <td v-bind:colspan="columns.length+2" class="text-center table-warning">
                                        <h4>Loading Data. Please Wait...</h4>
                                    </td>
                                </tr>
                                <tr v-else-if="!pagination.total_rec">
                                    <td v-bind:colspan="columns.length+2" class="text-center">
                                        No Record Found
                                    </td>
                                </tr>
                                <tr v-for="(row,i) in table_rows" v-bind:key="i" v-else>
                                    <td>{{ pagination.first_rec + i }}</td>
                                    <td v-for="(column,x) in table_columns" v-bind:key="x">
                                        {{row[column.name]}}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger" @click="deleteRecord(row)"  v-if="allow_delete"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row p-2">
                        <div class="col-sm">
                            <p class="text-center">
                                Showing record {{pagination.first_rec}} to {{pagination.last_rec}} (Total Records: {{pagination.total_rec}})
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="input-form" @submit.prevent="saveRecord()">
            <div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" v-for="(column,i) in columns" v-bind:key="i">
                            <label v-bind:for="column.name">{{column.display_name}}</label>

                            <select v-bind:name="column.name" class="form-control input-field" @change="generateSeries" v-if="column.type=='select'">
                                <option readonly selected value disabled> -- select an option -- </option>
                                <option v-for="(option, i) in droplists[column.name]" v-bind:key="i" v-bind:value="option.value">{{option.caption}}</option>
                            </select>

                            <input v-bind:type="column.type" class="form-control" v-bind:name="column.name" v-bind:placeholder="column.placeholder" v-bind:value="column.default_value" readonly v-else-if="column.default_value">

                            <input v-bind:type="column.type" v-bind:name="column.name" class="form-control input-field" v-bind:placeholder="column.placeholder" @keypress="lookup" v-bind:data-route="column.lookup_route" v-else-if="column.lookup_source">
                            
                            <input v-bind:type="column.type" v-bind:name="column.name" class="form-control input-field" v-bind:class="{ lookup: column.lookup_values }" v-bind:placeholder="column.placeholder" :readonly="column.lookup_values || column.system_generated" @change="generateSeries" v-else-if="column.generate_series">

                            <input v-bind:type="column.type" v-bind:name="column.name" class="form-control input-field" v-bind:class="{ lookup: column.lookup_values }" v-bind:placeholder="column.placeholder" :readonly="column.lookup_values || column.system_generated" v-else>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="clearInput()">Close</button>
                        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Save changes</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="modal fade" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import from Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <button class="btn btn-info btn-block" @click="downloadTemplate()">Click here to download template</button>
                    </div>

                    <form id="formup">
                        <div class="form-group">
                            <label for="file">Select template for uploading</label>
                            <input type="file" class="form-control-file" id="file" v-on:change="handleFileUpload()">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-secondary pull-right" disabled v-if="uploading">Uploading File. Please Wait.</button>
                    <button type="button" class="btn btn-primary pull-right" @click="uploadFile()" v-else><i class="fas fa-upload"></i> Import Data</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.initList();
            this.inquire();
        },
        data() {
            return {
                droplists: {},
                table_columns: [],
                table_rows: [],
                inquire_data: {},
                main_data: {},
                pagination: {},
                loading: false,
                uploading: false,
                file: ''
            }
        },
        created() {
            // this.inquire();
            this.populateLists();
        },
        props: {
            title: String,
            icon: String,
            route: String,
            columns: Array,
            source: String,
            user_id: String,
            xl_import: Boolean,
            allow_delete: false
        },
        methods: {
            initList() {
                let params = [];
                let fields = [];
                let cols = this.table_columns;
                let vm = this;

                $.each(this.columns,function() {
                    if (this.inquire) {
                        params[this.name] = '';
                    }

                    if (!this.hide_column) {
                        cols.push(this);
                    }

                    fields[this.name] = '';
                });

                vm.inquire_data = params;
                vm.main_data = fields;
            },
            inquire(page_url) {
                this.loading = true;

                let params = {};

                let p = [];
                let f = [];

                $.each(this.columns, function() {
                    f.push(this.name);
                    if (this.inquire) {
                        if ($("#"+this.name).val() != "" && $("#"+this.name).val() != null) {
                            if (this.inquire_type) {
                                p.push([this.name, this.inquire_type, $("#"+this.name).val() + '%']);
                            } else {
                                p.push([this.name, $("#"+this.name).val()]);
                            }
                        }
                    }
                });

                params['table'] = this.source;
                params['fields'] = f;
                params['lookup'] = p;
                
                fetch(page_url || '/api/portal/dataset/list', {
                    method: 'post',
                    body: JSON.stringify(params),
                    headers: {
                        'content-type': 'application/json'
                    }
                    })
                    .then(res => res.json())
                    .then(res => {
                        let vm = this;
                        this.table_rows = res.data;
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
            populateLists() {
                let cols = this.columns;
                let vm = this;

                $.each(cols, function(i) {
                    if (this.type == "select") {
                        if (this.list_route) {
                            fetch('/api/'+this.list_route, {
                                method: 'post',
                                })
                                .then(res => res.json())
                                .then(data => {
                                    let list = [];
                                    $.each(data.data, function(i) {
                                        list.push(this);
                                    });
                                    vm.droplists[this.name] = list;
                                })
                                .catch(err => console.log(err));
                        } else if (this.static_list) {
                            vm.droplists[this.name] = this.static_list;
                        }
                    }
                });
            },
            saveRecord() {
                let data = {};
                data = $("#input-form").serializeArray();

                let params = {};

                params['table'] = this.source;
                params['data'] = data;
                params['user_id'] = this.user_id;

                fetch('/api/portal/dataset', {
                    method: 'post',
                    body: JSON.stringify(params),
                    headers: {
                        'content-type': 'application/json'
                    }
                    })
                    .then(res => res.json())
                    .then(data => {
                        // this.errors = data.Errors;
                        // if (data.Results != undefined) {
                            if (data != "") {
                                alert(data);
                            } else {
                                this.inquire();
                                this.clearInput();
                                $("#AddModal").modal('toggle');
                            }
                        // }
                    })
                    .catch(err => console.log(err));
            },
            deleteRecord(row) {
                if (confirm('Are You Sure?')) {
                    let params = {};

                    params['table'] = this.source;
                    params['data'] = row;
                    params['user_id'] = this.user_id;

                    fetch('/api/portal/dataset', {
                        method: 'delete',
                        body: JSON.stringify(params),
                        headers: {
                            'content-type': 'application/json'
                        }
                        })
                        .then(res => res.json())
                        .then(data => {
                            // this.errors = data.Errors;
                            // if (data.Results != undefined) {
                                if (data != "") {
                                    alert(data);
                                } else {
                                    this.inquire();
                                }
                            // }
                        })
                        .catch(err => console.log(err));
                }
            },
            downloadTemplate() {
                let cols = {};
                cols['name'] = this.title;
                cols['columns'] = this.columns;
                
                axios({
                    url: '/api/portal/dataset/template',
                    method: 'post',
                    data: JSON.stringify(cols),
                    headers: {
                        'content-type': 'application/json'
                    },
                    responseType: 'blob', // important
                    }).then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', this.title + ' Template.xls'); //or any other extension
                        document.body.appendChild(link);
                        link.click();
                    });
            },
            handleFileUpload() {
                this.file = $("#file")[0].files[0];
            },
            uploadFile() {
                if ($('#file').get(0).files.length === 0) {
                    alert("No template selected. Please select an upload temaplte first.");
                } else {
                let vm = this;
                vm.uploading = true;

                let mytitle = this.title;
                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('table', this.source);
                formData.append('columns', JSON.stringify(this.columns));
                formData.append('user_id', this.user_id);
                formData.append('name', mytitle);
                
                axios.post( '/api/portal/dataset/upload',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                    ).then(function(response){
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', mytitle + ' - Upload Results.csv'); //or any other extension
                        document.body.appendChild(link);
                        link.click();

                        $("#file").val('');
                        vm.uploading = false;
                    })
                    .catch(function(err){
                        console.log(err);

                        vm.uploading = false;
                    });
                }
            },
            lookup: function (event) {
                if (event.which == 13) {
                    event.preventDefault();
                    this.lookupData(event.target.getAttribute('data-route'),event.target.value)
                }
            },
            lookupData(route, value) {
                let params = {};

                params['lookup_value'] = value;

                fetch('/api/' + route, {
                    method: 'post',
                    body: JSON.stringify(params),
                    headers: {
                        'content-type': 'application/json'
                    }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            $.each(data[0],function(i,v) {
                                $('#input-form').find('input[name='+i+']').val(v);
                            });
                        } else {
                            alert("You have entered an invalid serial number.");
                            $('.lookup').val("");
                        }
                    })
                    .catch(err => console.log(err));
            },
            clearInput() {
                $('.input-field').val("");
            },
            generateSeries: function(event) {
                let cols = this.columns;
                let vm = this;
                // console.log(event ? event.target.name : event);
                // console.log(event ? event.target.value : event);

                let d = {};
                let params = '';

                $.each(cols,function(i) {
                    if (this.generate_series) {
                        if ($('#input-form').find((this.type=="select" ? 'select' : 'input')+'[name='+this.name+']').val() != undefined) {
                            params += "/" + $('#input-form').find((this.type=="select" ? 'select' : 'input')+'[name='+this.name+']').val();
                        } 
                    }
                });

                // console.log(JSON.stringify(d));

                $.each(cols, function(i) {
                    if (this.system_generated) {
                        let c = this;
                        let url = this.system_generated + params;

                        if (this.system_generated) {
                            fetch('/api/'+url, {
                                method: 'post',
                                })
                                .then(res => res.json())
                                .then(data => {
                                    $('#input-form').find('input[name='+c.name+']').val(data);
                                })
                                .catch(err => console.log(err));
                        }                  
                    }   
                });
            }
        }
    }
</script>
