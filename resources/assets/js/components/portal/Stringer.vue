<template>
    <div>
        <div class="card" v-if="machine!='-'">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Production Line</label>
                            <input type="text" class="form-control" name="" id="" v-model="line" readonly>
                        </div>
                    </div>

                    <div class="col-sm">
                        <label for="">Machine</label>
                        <input type="text" class="form-control" name="" id="" v-model="machine" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" v-if="machine!='-'">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#" id="lot-tab" class="nav-link" v-bind:class="active_tab == 'lot-tab' ? 'active' : ''" @click="changeTab">Data Entry</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" id="sno-tab" class="nav-link" v-bind:class="active_tab == 'sno-tab' ? 'active' : ''" @click="changeTab">Transaction Logs</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card" id="lots" v-if="active_tab == 'lot-tab'">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-row">
                            <label for="lot_id">Lot Number</label>
                            <input type="text" class="form-control" name="lot_id" id="lot_id" v-on:keyup.13="addRecord" :disabled="transaction.lot_ids.length == max_lot" v-on:keydown.9="moveSNO" autofocus>
                            <span id="lot-msg" v-bind:class="messages.lot.class">{{messages.lot.msg}}</span>
                        </div>
                    </div>

                    <div class="col-sm-8 mb-2">
                        <label>Lot ID Listing</label>
                        <table class="table table-sm table-condensed table-striped">
                            <thead class="thead-dark">
                                <th>#</th>
                                <th>Lot ID / Parent Lot</th>
                                <th>Part Number / Description</th>
                                <th>Qty</th>
                                <th>Actions</th>
                            </thead>
                            <tbody style="font-size: 0.9em;" class="align-middle">
                                <tr v-for="(lot,i) in transaction.lot_ids" v-bind:key="i" v-bind:class="lot.used > 0 ? 'text-info' : ''">
                                    <td>{{i+1}}</td>
                                    <td>{{lot.lot_id}} <br>
                                        {{lot.parent_lot}} </td>
                                    <td>{{lot.part_number}} <br>
                                        {{lot.description}}</td>
                                    <td>{{lot.qty}}</td>
                                    <td><button class="btn btn-sm btn-danger" @click="deleteRecord(lot)"><i class="fas fa-trash"></i> Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-row">
                            <label for="sno">Serial Number</label>
                            <input type="text" class="form-control" name="sno" id="sno" :disabled="transaction.lot_ids.length == 0" v-on:keyup.13="addTransaction" v-on:keydown.9="moveLot">
                            <span id="lot-msg" v-bind:class="messages.sno.class">{{messages.sno.msg}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="snos" v-else>
            <div class="card-body">
                <label>Transaction Log</label>
                <div class="row">
                    <div class="col-sm">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item" v-bind:class="[{ disabled: !pagination.prev_page }]" @click="!!pagination.prev_page && refreshTransactions(pagination.prev_page)"><a class="page-link" href="#"><i class="fas fa-backward"></i></a></li>

                                <li class="page-item disabled" v-if="pagination.total_rec"><a class="page-link" href="#" >Page {{pagination.curr_page}} of {{pagination.last_page}}</a></li>

                                <li class="page-item disabled" v-else><a class="page-link" href="#">No Record Found</a></li>
                                
                                <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page }]"><a class="page-link" href="#" @click="!!pagination.next_page && refreshTransactions(pagination.next_page)"><i class="fas fa-forward"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-sm text-right" v-if="machine=='-'">
                        <button class="btn btn-info" data-toggle="modal" data-target="#filter"><i class="fas fa-filter"></i> Filter Results</button>
                        <button class="btn btn-success"><i class="fas fa-file-csv"></i> Export Data</button>
                    </div>
                </div>
                <table class="table table-sm table-condensed table-striped">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th v-if="machine=='-'">Line</th>
                        <th v-if="machine=='-'">Station</th>
                        <th v-if="machine=='-'">Machine</th>
                        <th>Serial Number</th>
                        <th>Trx Date</th>
                        <th>Lot # 1</th>
                        <th>Lot # 2</th>
                    </thead>
                    <tbody>
                        <tr v-if="loading==true">
                            <td class="text-center" v-bind:colspan="machine=='-' ? 8 : 5">Loading Records. Please wait...</td>
                        </tr>
                        <tr v-else-if="transactions.length==0">
                            <td class="text-center" v-bind:colspan="machine=='-' ? 8 : 5">No Record Found</td>
                        </tr>
                        <tr v-for="(trx,i) in transactions" v-bind:key="i" v-else>
                            <td>{{pagination.first_rec+i}}</td>
                            <td v-if="machine=='-'">{{trx.PRODLINE}}</td>
                            <td v-if="machine=='-'">{{trx.LOCNCODE}}</td>
                            <td v-if="machine=='-'">{{trx.MACHINE}}</td>
                            <td>{{trx.SERIALNO}}</td>
                            <td>{{trx.TRXDATE}}</td>
                            <td>{{trx.LOT1}}</td>
                            <td>{{trx.LOT2}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filterLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter Results</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-4">
                            Date Range
                        </div>

                        <div class="col-sm-8">
                            <div class="form-group">
                                <input type="date" name="start" id="start" class="form-control mb-2" v-model="start_date">
                                <input type="date" name="end" id="end" class="form-control" v-model="end_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-sm-4">
                            Stringer Machine
                        </div>

                        <div class="col-sm-8">
                            <div class="form-row">
                                <div class="col-sm">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW1" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW2" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW3" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 3</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-sm">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW4" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW5" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 5</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW6" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 6</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-sm">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW7" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 7</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW8" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 8</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="machine[]" value="ATW9" @click="machineSelect">
                                        <label class="form-check-label" for="machine">ATW # 9</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="refreshTransactions()">Refresh Data</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.start_date = this.date;
        this.end_date = this.date;

        this.refreshTransactions();
        if (this.machine != "-") {
            this.active_tab = 'lot-tab';
        } else {
            this.active_tab = 'sno-tab';
        }
    },
    created() {
        
    },
    data() {
        return {
            active_tab: '',
            transactions: [],
            transaction: {
                LOCNCODE: '',
                PRODLINE: '',
                MACHINE: '',
                SERIALNO: '',
                UIDTRANS: '',
                lot_ids: [],
            },
            lots: [],
            messages: {
                lot: {
                    msg: '',
                    class: 'text-success',
                },
                sno: {
                    msg: '',
                    class: 'text-success',
                },
            },
            lot_detail: {
                lot_id: '',
                parent_lot: ''
            },
            max_lot: 2,
            pagination: {},
            machines: [],
            start_date: '',
            end_date: '',
            loading: false
        }
    },
    props: {
        line: String,
        prodline: String,
        station: String,
        machine: String,
        user_id: String,
        date: Date
    },
    methods: {
        changeTab: function(event) {
            this.active_tab = event.target.id;
        }, 
        addRecord: function(event) {
            let vm = this;
            
            if (event.target.value != '') {
                fetch('/api/mes/lot/check/' + event.target.value, {
                    method: 'get',
                    })
                    .then(res => res.json())
                    .then(data => {
                        vm.messages.sno.msg = "";
                        vm.messages.lot.class = "text-danger";
                        if (data.results.length == 0) {
                            vm.messages.lot.msg = 'Lot ID does not exists.';
                        } else if (data.results[0].used >= 2) {
                            vm.messages.lot.msg = 'This Lot ID was already used ' + data.results[0].used + ' time/s.';
                        } else if (vm.lots.includes(event.target.value)) {
                            vm.messages.lot.msg = 'This Lot ID is already scanned.';
                        } else {
                            vm.messages.lot.msg = event.target.value + " is successfully added.";
                            vm.messages.lot.class = "text-success";

                            vm.transaction.lot_ids.push(data.results[0]);
                            vm.lots.push(event.target.value);

                            if (vm.transaction.lot_ids.length == 2) {
                                $("#sno").focus();
                            }

                            event.target.value = '';
                        }
                    })
                    .catch(err => console.log(err));
            }
        },
        deleteRecord(row) {
            this.lots.splice(row,1);
            this.transaction.lot_ids.splice(row,1);
        },
        addTransaction: function(event) {
            let vm = this;

            let formData = new FormData();
            formData.append('serial', event.target.value);
            formData.append('station', this.station);

            axios.post( '/mes/validate',
            formData
            ).then(function(response){
                vm.messages.lot.msg = "";

                if (response.data.errors.error_msg == "") {
                    vm.transaction.LOCNCODE = vm.station;
                    vm.transaction.PRODLINE = vm.prodline;
                    vm.transaction.MACHINE = vm.machine;
                    vm.transaction.SERIALNO = event.target.value;
                    vm.transaction.UIDTRANS = vm.user_id;

                    vm.saveTransaction(event.target);
                } else {
                    event.target.value = '';
                    vm.messages.sno.class = "text-danger";
                    vm.messages.sno.msg = response.data.errors.error_msg;
                }
            })
            .catch(function(err){
                console.log(err);
            });
        },
        saveTransaction(serial) {
            let mydata = {};
            let vm = this;

            mydata['params'] = JSON.stringify(JSON.stringify(this.transaction));

            fetch('/api/mes/stringer', {
                    method: 'post',
                    body: JSON.stringify(mydata),
                    headers: {
                        'content-type': 'application/json'
                    }
                    })
                    .then(res => res.json())
                    .then(data => {
                            if (data != "") {
                                vm.messages.sno.msg = data;
                                vm.messages.sno.class = "text-danger";
                            } else {
                                let rm = [];
                                $.each(vm.transaction.lot_ids,function() {
                                    if (this.used == 1) {
                                        rm.push(this);
                                    } else {
                                        this.used++;
                                    }
                                });

                                $.each(rm, function() {
                                    vm.deleteRecord(this);
                                });

                                vm.messages.sno.class = "text-success";
                                vm.messages.sno.msg = "["+vm.transaction.SERIALNO+"] is successfully transacted.";

                                vm.refreshTransactions();

                                serial.value = "";
                            }
                    })
                    .catch(err => console.log(err));
        },
        moveSNO: function(event) {
            event.preventDefault();
            $("#sno").focus();
        },
        moveLot: function(event) {
            event.preventDefault();
            $("#lot_id").focus();
        },
        refreshTransactions(page_url) {
            let vm = this;
            let mydata = {};

            vm.loading = true;

            mydata['params'] = JSON.stringify(JSON.stringify(this.machines));

            fetch(page_url || '/api/mes/stringer/trx/' + this.station + "/" + this.machine + "/" + this.start_date + "/" + this.end_date, {
                    method: 'post',
                    body: JSON.stringify(mydata),
                    headers: {
                        'content-type': 'application/json'
                    }
                    })
                    .then(res => res.json())
                    .then(res => {
                        vm.transactions = res.data;
                        vm.makePagination(res.next_page_url, res.prev_page_url, res.current_page, res.last_page, res.from, res.to, res.total);

                        vm.loading = false;
                    })
                    .catch(err => {
                        console.log(err);
                        vm.loading = false;
                    });
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
        machineSelect: function(event) {
            if (event.target.checked) {
                this.machines.push(event.target.value);
            } else {
                this.machines.splice(event.target.value,1);
            }
        }
    }
}
</script>