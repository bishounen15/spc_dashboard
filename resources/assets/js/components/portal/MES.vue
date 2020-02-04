<template>
    <div>
        <div class="row">
            <div class="col-sm-8">
                <h2><i class="fas fa-qrcode"></i> Line Transactions [{{station_desc}}]</h2>
            </div>
            <div class="col-sm-4 text-right">
                <h5>{{prod_date}} - Shift {{ shift + (line == null ? "" : " - " + line_desc + " [" + (registration || 'No Govt. Registration') + "]") }}</h5>
                <h6>Operator: [{{uid}}] {{user_name}}</h6>
            </div>
        </div>

        <div :hidden="transact">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-sm-4 text-right">
                            Scan Serial Number
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="sno" id="sno" placeholder="Scan your serial here" v-model="sno" v-on:keyup.13="validation" :disabled="loading || transact || validating || processing" autofocus>
                            <span class="form-text text-danger" id="err_sno">{{messages.error}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body m-0 p-2">
                <div class="row">
                    <div class="col-sm">
                        <nav aria-label="Page navigation example" style="font-size: 0.75em;">
                            <ul class="pagination">
                                <li class="page-item" v-bind:class="[{ disabled: (pagination.curr_page <= pagination.first_page || !pagination.total_rec) }]" @click="prevPage()"><a class="page-link" href="#"><i class="fas fa-backward"></i></a></li>

                                <li class="page-item disabled" v-if="pagination.total_rec"><a class="page-link" href="#" >Page {{pagination.curr_page}} of {{pagination.last_page}}</a></li>

                                <li class="page-item disabled" v-else><a class="page-link" href="#">No Record Found</a></li>
                                
                                <li class="page-item" v-bind:class="[{ disabled: (pagination.curr_page >= pagination.last_page || !pagination.total_rec) }]"><a class="page-link" href="#" @click="nextPage()"><i class="fas fa-forward"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-sm text-right">
                        <p>
                            Showing record {{pagination.first_rec || 0}} to {{pagination.last_rec || 0}} (Total Records: {{transactions.length}})
                        </p>
                    </div>
                </div>
                
                <table class="table table-condensed table-striped table-sm" id="mes-list" style="width: 100%;">
                    <thead class="thead-dark" style="font-size: 0.7em;">
                        <th width="10%">Serial Number</th>
                        <th width="10%">Model</th>
                        <th width="5%">Line</th>
                        <th width="5%">Class</th>
                        <th width="5%">Location</th>
                        <th width="5%">Customer</th>
                        <th width="10%">Trx. Date</th>
                        <th width="10%">Scan Date</th>
                        <th width="5%">Shift</th>
                        <th width="5%">Status</th>
                        <th width="20%">Remarks</th>
                        <th width="10%">User</th>
                    </thead>
                    <tbody class="tbody-light" style="font-size: 0.75em;">
                        <tr v-if="loading">
                            <td colspan="12" class="text-center">Loading Data. Please Wait...</td>
                        </tr>
                        <tr v-else-if="pagination.total_rec == 0">
                            <td colspan="12" class="text-center">No Record found</td>
                        </tr>
                        <tr v-for="(transaction, i) in list" v-bind:key="i" v-else>
                            <td>{{transaction.SERIALNO}}</td>
                            <td>{{transaction.MODEL}}</td>
                            <td>{{transaction.PRODLINE}}</td>
                            <td>{{transaction.MODCLASS}}</td>
                            <td>{{transaction.LOCNCODE}}</td>
                            <td>{{transaction.CUSTOMER}}</td>
                            <td>{{transaction.DATE}}</td>
                            <td>{{transaction.TRXDATE}}</td>
                            <td>{{transaction.SHIFT}}</td>
                            <td>{{transaction.STATUS}}</td>
                            <td>{{transaction.REMARKS}}</td>
                            <td>{{transaction.USER}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>

        <div :hidden="!transact">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm">
                            <strong>Transaction Details</strong>
                        </div>
                        <div class="col-sm text-right">
                            <button class="btn btn-success" id="SaveButton" :disabled="(transaction.data.MODCLASS == '' && class_list.length > 0) || processing" @click="save()">{{processing ? "Saving..." : "Save (Ctrl + S)"}}</button>
                            <button type="button" class="btn btn-secondary" :hidden="processing" @click="toggle">Cancel (Esc)</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="jumbotron p-3 bg-danger text-center text-white" :hidden="messages.warning==''">
                        <h3 class="display-6" id="warn-msg">{{messages.warning}}</h3>
                    </div>

                    <div class="form-row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="serialno">Serial Number</label>
                                <input type="text" class="form-control form-control-sm" name="serialno" id="serialno" v-model="lookup.SERIALNO" readonly>
                            </div>
            
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <input type="text" class="form-control form-control-sm" name="customer" id="customer" v-model="lookup.CUSTOMER" readonly>
                            </div>
            
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control form-control-sm" name="model" id="model" v-model="lookup.MODELNAME" readonly>
                            </div>
            
                            <div class="form-group">
                                <label for="station">Recent Location</label>
                                <input type="text" class="form-control form-control-sm" name="station" id="station" v-model="lookup.RECENTLOC" readonly>
                            </div>

                            <div class="form-group">
                                <label for="class">Current Class</label>
                                <input type="text" class="form-control form-control-sm" name="class" id="class" v-model="lookup.CURRENTCLASS" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 offset-sm-1">
                            <div class="form-group">
                                <div class="form-row">
                                    <label for="status">Module Status</label>
                                </div>
                                
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="stat0" value="0" @change="optionChange()" v-model="transaction.data.SNOSTAT" :checked="transaction.data.SNOSTAT == 0">
                                    <label class="form-check-label" for="inlineRadio1">Good</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="stat1" value="1" @change="optionChange()" v-model="transaction.data.SNOSTAT" :checked="transaction.data.SNOSTAT == 1">
                                    <label class="form-check-label" for="inlineRadio2">MRB</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="stat2" value="2" @change="optionChange()" v-model="transaction.data.SNOSTAT" :checked="transaction.data.SNOSTAT == 2">
                                    <label class="form-check-label" for="inlineRadio3">Scrap</label>
                                </div>
                                
                                <div class="form-check form-check-inline" :hidden="station!='MRB'">
                                    <input class="form-check-input" type="radio" name="status" id="stat3" value="3">
                                    <label class="form-check-label" for="inlineRadio3">RMA</label>
                                </div>

                                <div class="form-check form-check-inline" :hidden="station!='MRB'">
                                    <input class="form-check-input" type="radio" name="status" id="stat4" value="4">
                                    <label class="form-check-label" for="inlineRadio3">STFET</label>
                                </div>
                                
                            </div>

                            <div class="form-group">
                                <label for="class">Module Class</label>
                                <select class="form-control form-control-sm" name="modclass" id="modclass" v-model="transaction.data.MODCLASS" @change="warningMessage()">
                                    <option disabled selected value="">Module Class Select...</option>
                                    <option v-for="(classes,index) in class_list" v-bind:key="index" v-bind:value="classes.MCLCODE">{{ classes.MCLDESC }}</option>
                                </select>
                                <small class="form-text text-danger" id="err_modclass"></small>
                            </div>

                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="8" v-model="transaction.data.REMARKS"></textarea>
                                <small class="form-text text-danger" id="err_remarks"></small>
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
        this._keyListener = function(e) {
            if (e.key.toLowerCase() === "s" && (e.ctrlKey || e.metaKey)) {
                e.preventDefault();
                this.save();
            } else if (e.key === "Escape") {
                e.preventDefault();
                this.cancel();
            }
        };

        document.addEventListener('keydown', this._keyListener.bind(this));
    },
    beforeDestroy() {
        document.removeEventListener('keydown', this._keyListener);
    },
    data() {
        return {
            transact: false,
            loading: false,
            validating: false,
            processing: false,
            messages: {
                warning: '',
                error: '',
                custom: {
                    class: '',
                    message: '',
                    auto_remarks: '',
                }
            },
            status: ["Good","MRB","Scrap"],
            record_per_page: 25,
            pagination: {},
            transactions: [],
            transaction: {
                data: {
                    SERIALNO: '',
                    LOCNCODE: '',
                    SNOSTAT: 0,
                    MODCLASS: '',
                    REMARKS: '',
                    USERID: '',
                    PRODLINE: 0,
                }
            },
            list: [],
            classes: [],
            class_list: [],
            sno: '',
            lookup: {},
        }
    },
    created() {
        this.listTransactions();
        let trx = this.transaction.data;

        trx.USERID = this.uid;
        trx.PRODLINE = this.line;
    },
    props: {
        line: String,
        line_desc: String,
        station: String,
        station_desc: String,
        station_id: String,
        uid: String,
        user_name: String,
        registration: String,
        prod_date: String,
        shift: String,
    },
    methods: {
        toggle: function(e) {
            this.transact = !this.transact; 
            if (!this.transact) {
                let isDisabled = setInterval(function() {
                    if (!$("#sno").prop('disabled')) {
                        clearInterval(isDisabled);
                        $("#sno").focus();
                    }
                }, 100);
            }
        },
        save(auto) {
            let vm = this;
            let auto_save = auto || false;

            if (vm.transact || auto_save) {
                if (!vm.processing || auto_save) {
                    if (!(vm.transaction.data.MODCLASS == "" && vm.class_list.length > 0)) {
                        let trx = vm.transaction.data;

                        let data = {
                                        SERIALNO: trx.SERIALNO,
                                        MODEL: vm.lookup.MODELNAME,
                                        PRODLINE: vm.line_desc,
                                        MODCLASS: trx.MODCLASS,
                                        LOCNCODE: trx.LOCNCODE,
                                        CUSTOMER: vm.lookup.CUSTOMER,
                                        DATE: vm.prod_date,
                                        TRXDATE: '',
                                        SHIFT: "Shift " + vm.shift,
                                        STATUS: vm.status[trx.SNOSTAT],
                                        REMARKS: (auto_save ? vm.messages.custom.auto_remarks : trx.REMARKS),
                                        USER: vm.user_name,
                                    };

                        vm.processing = true;

                        fetch('/api/mes/save', {
                            method: 'post',
                            body: JSON.stringify(trx),
                            headers: {
                                'content-type': 'application/json'
                            }
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.Message == "") {
                                    data.TRXDATE = res.Data.TRXDATE;
                                    data.REMARKS = res.Data.REMARKS;

                                    vm.transactions.unshift(data);
                                    vm.makePagination(vm.transactions.length, vm.record_per_page);
                                    vm.listRecords();

                                    if (!auto_save) { vm.toggle(); }
                                } else {
                                    alert(res.Message);
                                }

                                vm.processing = false;
                            })
                            .catch(err => console.log(err));
                    }
                } else {
                    alert("Module Class is required.")
                }
            }
        },
        cancel: function(e) {
            if (this.transact) {
                if (!this.processing) {
                    this.toggle();
                }
            }
        },
        listTransactions() {
            let vm = this;
            vm.loading = true;
            
            fetch('/api/mes/transactions/' + vm.prod_date + '/' + vm.shift + '/' + vm.station_id + '/' + (vm.line || '') , {
                method: 'post'
                })
                .then(res => res.json())
                .then(res => {
                    vm.transactions = res.data;
                    vm.makePagination(vm.transactions.length, vm.record_per_page);
                    vm.listRecords();
                    this.loading = false;

                    let isDisabled = setInterval(function() {
                        if (!$("#sno").prop('disabled')) {
                            clearInterval(isDisabled);
                            $("#sno").focus();
                        }
                    }, 100);
                })
                .catch(err => console.log(err));
        },
        makePagination(total_records,paginate) {
            let pagination = {
                    curr_page: 1,
                    first_page: 1,
                    last_page: Math.ceil(total_records/paginate),
                    first_rec: 1,
                    last_rec: (paginate < total_records ? paginate : total_records),
                    total_rec: total_records,
                    rec_per_page: paginate,
                }

            this.pagination = pagination;
        },
        nextPage() {
            if (this.pagination.curr_page < this.pagination.last_page) {
                this.pagination.curr_page++;
                this.changeRecords();
            }
        },
        prevPage() {
            if (this.pagination.curr_page > this.pagination.first_page) {
                this.pagination.curr_page--;
                this.changeRecords();
            }
        },
        changeRecords() {
            this.pagination.first_rec = (this.pagination.rec_per_page * (this.pagination.curr_page - 1)) + 1;
            this.pagination.last_rec = this.pagination.rec_per_page * this.pagination.curr_page;

            if (this.pagination.last_rec > this.pagination.total_rec) {
                this.pagination.last_rec = this.pagination.total_rec;
            }
            
            this.listRecords();
        },
        listRecords() {
            let p = this.pagination
            let l = [];
            let i;
            
            for(i=p.first_rec;i<=p.last_rec;i++) {
                if (i >= p.first_rec && i <= p.last_rec) {
                    l.push(this.transactions[i-1]);
                }
            }

            this.list = l;
        },
        validation: function(e) {
            let vm = this;
            let data = {
                "SERIALNO": e.target.value,
                "REGISTRATION": vm.registration,
                "STATION": vm.station,
                "PRODLINE": vm.line,
                "TRXDATE": vm.prod_date,
                "TRXLAST": (vm.transactions.length > 0 ? vm.transactions[0] : [])
            };

            vm.validating = true;
            vm.messages.error = 'Checking module information...';

            fetch('/api/mes/validate', {
                method: 'post',
                body: JSON.stringify(data),
                headers: {
                    'content-type': 'application/json'
                }
                })
                .then(res => res.json())
                .then(res => {
                    vm.messages.error = res.Messages.Error;
                    vm.lookup = res.Data;
                    vm.classes = vm.lookup.Classes;

                    vm.messages.custom.class = (res.Data.Warning != null ? res.Data.Warning.Class : '')
                    vm.messages.custom.message = (res.Data.Warning != null ? res.Data.Warning.Message : '')

                    if (res.Messages.Error == "") {
                        vm.transaction.data.SERIALNO = vm.lookup.SERIALNO;
                        vm.transaction.data.LOCNCODE = vm.station;
                        vm.transaction.data.SNOSTAT = (vm.lookup.LAST_TRX ? vm.lookup.LAST_TRX.SNOSTAT : 0);
                        vm.optionChange();
                        vm.transaction.data.MODCLASS = (vm.lookup.LAST_TRX ? vm.lookup.LAST_TRX.MODCLASS : (vm.class_list.length > 0 ? vm.class_list[0].MCLCODE : ''));
                        vm.transaction.data.REMARKS = (vm.lookup.LAST_TRX ? vm.lookup.LAST_TRX.REMARKS : vm.status[0]);
                        
                        if (res.Data.auto_save) {
                            vm.messages.custom.auto_remarks = res.Data.auto_remarks;
                            vm.save(res.Data.auto_save);
                        } else {
                            vm.warningMessage();
                            vm.toggle();
                        }
                    }

                    vm.sno = "";

                    vm.validating = false;
                    if (res.Messages.error == "") { vm.messages.error = ''; }

                    let isDisabled = setInterval(function() {
                        if (!$("#sno").prop('disabled')) {
                            clearInterval(isDisabled);
                            $("#sno").focus();
                        }
                    }, 100);
                })
                .catch(err => console.log(err));
        },
        optionChange() {
            let list = [];
            let vm = this;

            vm.classes.forEach(element => {
                if (element.MODSTATUS == vm.transaction.data.SNOSTAT) {
                    list.push(element);
                }                
            });

            if (list.length == 0) {
                vm.transaction.data.MODCLASS = "";
            }

            vm.class_list = list;
            vm.warningMessage();
        },
        warningMessage() {
            if (this.messages.custom.class != "" && this.messages.custom.class != this.transaction.data.MODCLASS) {
                this.messages.warning = this.messages.custom.message;
            } else {
                this.messages.warning = "";
            }
        }
    }
}
</script>