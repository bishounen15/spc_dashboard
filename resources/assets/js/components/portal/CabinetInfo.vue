<template>
    <div>
        <h3 class="mb-4"><i class="fas fa-tasks"></i> {{title}}</h3>
        <div id="record-list" class="card" v-bind:style="[{ display: (this.create == true ? 'none' : 'block') }]">
            <div class="card-header bg-warning text-white">
                {{title}} List
            </div>
            <div class="card-body pt-1 pb-1 pr-3 pl-3">
                <div class="row">
                    <div class="col-sm pt-0 pb-2 pl-3 pr-1">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item" v-bind:class="[{ disabled: !pagination.prev_page }]" @click="!!pagination.prev_page && inquire(pagination.prev_page)"><a class="page-link" href="#"><i class="fas fa-backward"></i></a></li>

                                <li class="page-item disabled" v-if="pagination.total_rec"><a class="page-link" href="#" >Page {{pagination.curr_page}} of {{pagination.last_page}}</a></li>

                                <li class="page-item disabled" v-else><a class="page-link" href="#">No Record Found</a></li>
                                
                                <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page }]"><a class="page-link" href="#" @click="!!pagination.next_page && inquire(pagination.next_page)"><i class="fas fa-forward"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-sm pt-0 pb-2 pl-1 pr-3 text-right">
                        <button id="AddRecord" class="btn btn-info" @click="createCabinet()">
                            <i class="fas fa-plus-circle"></i> Add Record
                        </button>

                        <button id="ShipCabinet" class="btn btn-success pull-right" :disabled="this.cabinets_selected.length==0" data-toggle="modal" data-target="#ShipModal">
                            <i class="far fa-check-square"></i> Mark as Shipped
                        </button>
                    </div>
                </div>

                <div class="row pt-0 pb-2 pl-3 pr-3">
                    <table class="table table-sm table-condensed table-striped">
                        <thead class="thead-dark">
                            <th>#</th>
                            <th>Cabinet Number</th>
                            <th>Date</th>
                            <th>Registration</th>
                            <th>No. of Pallets</th>
                            <th>Number of Modules</th>
                            <th>Date Shipped</th>
                        </thead>
                        <tbody>
                            <tr v-for="(cabinet,i) in cabinets" v-bind:key="i">
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="selectedContainer[]" v-bind:value="cabinet.CABINETNO" :disabled="cabinet.SHIPDATE != null" @change="selectCabinet">
                                    </div>
                                </td>
                                <td>{{cabinet.CABINETNO}}</td>
                                <td>{{cabinet.TRXDATE}}</td>
                                <td>{{cabinet.REGISTRATION}}</td>
                                <td>{{cabinet.PALLETS}}</td>
                                <td>{{cabinet.MODULES}}</td>
                                <td>{{cabinet.SHIPDATE}}</td>
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

        <div id="create-cabinet" class="card"  v-bind:style="[{ display: (this.create == false ? 'none' : 'block') }]">
            <div class="card-header bg-info text-white">
                Create {{title}}
            </div>
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                Cabinet Details
                            </div>
                            <div class="card-body">
                                <form id="input-form">
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            Cabinet Number
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control cabinet-details" name="CABINETNO" id="CABINETNO" placeholder="System-Generated Number" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            Date
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control cabinet-details" name="TRXDATE" id="TRXDATE" placeholder="Date of Transaction" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            Registration
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control cabinet-details" name="REGISTRATION" id="REGISTRATION" placeholder="Government Registration" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer p-1">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button id="SaveButton" class="btn btn-success btn-block" :disabled="pallets.length < max_pallets" @click="saveCabinet()">
                                            Save Cabinet
                                        </button>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <button id="CancelButton" class="btn btn-danger btn-block" @click="createCabinet()">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                Pallet Details
                            </div>
                            <div class="card-body">
                                <div class="form-row pb-2">
                                    <div class="col-sm-4">
                                        Scan Pallet Number
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="PALLETNO" id="PALLETNO" class="form-control" v-on:keyup.enter="checkPallet" :disabled="pallets.length == max_pallets" autofocus>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-sm table-condensed table-striped">
                                        <thead class="thead-dark">
                                            <th>#</th>
                                            <th>Pallet Number</th>
                                            <th>Customer</th>
                                            <th>Registration</th>
                                            <th>Number of Modules</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(pallet,i) in pallets" v-bind:key="i">
                                                <td>{{i+1}}</td>
                                                <td>{{pallet.pallet_no}}</td>
                                                <td>{{pallet.customer}}</td>
                                                <td>{{pallet.registration}}</td>
                                                <td>{{pallet.modules}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ShipModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white"><strong>Mark as Shipped</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Do you really want to tag the marked containers as <strong>SHIPPED</strong>?
                    </p>
                    <form id="ship-details">
                        <div class="form-group">
                            <label for="SHIPDATE">Shipment Date</label>
                            <input type="date" class="form-control form-control-sm" name="SHIPDATE" id="SHIPDATE" value="">
                            <span class="text-danger" id="err_SHIPDATE"></span>
                        </div>

                        <div class="form-group">
                            <label for="CIPLNO">CIPL No.</label>
                            <input type="text" class="form-control form-control-sm" name="CIPLNO" id="CIPLNO">
                            <span class="text-danger" id="err_CIPLNO"></span>
                        </div>

                        <!-- <div class="form-group">
                            <label for="PINO">PL No.</label>
                            <input type="text" class="form-control form-control-sm" name="PINO" id="PINO">
                            <span class="text-danger" id="err_PINO"></span>
                        </div> -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="ShipButton" @click="shipCabinets()">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.listCabinets();
        $(".invalid-feedback").show();
    },
    data() {
        return {
            cabinets: [],
            cabinets_selected: [],
            pallets: [],
            pallet_nos: [],
            pallet_info: {
                pallet_no: '',
                cabinet_no: '',
                customer: '',
                registration: '',
                modules: 0
            },
            create: false,
            max_pallets: 16,
            pagination: {}
        }
    },
    created() {
        
    },
    props: {
        title: String,
        production_line: Number,
        line_desc: String,
        registration: String,
        user_id: String,
    },
    methods: {
        createCabinet () {
            this.create = !this.create;

            if (this.create) {
                $("PALLETNO").focus();
            } else {
                $(".cabinet-details").val("");
                $(".invalid-feedback").html("");
                this.pallets = [];
                this.pallet_nos = [];
            }
        }, 
        listCabinets(page_url) {
            let vm = this;

            fetch(page_url || '/api/mes/cabinet/list', {
                method: 'post',
                })
                .then(res => res.json())
                .then(res => {
                    this.cabinets = res.data;
                    vm.makePagination(res.next_page_url, res.prev_page_url, res.current_page, res.last_page, res.from, res.to, res.total);
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
        checkPallet: function(event) {
            let pallets = this.pallets;
            let pallet_nos = this.pallet_nos;
            let pallet_no = event.target.value;

            fetch('/api/mes/cabinet/pallet/check/'+pallet_no, {
                method: 'post',
                })
                .then(res => res.json())
                .then(data => {
                    if (data.pallet_no == undefined) {
                        $(".invalid-feedback").html("Pallet Number ["+pallet_no+"] does not exists.");
                    } else {
                        if (data.cabinet_no != "") {
                            $(".invalid-feedback").html("Pallet Number ["+pallet_no+"] is already assigned to Cabinet Number ["+data.cabinet_no+"].");
                        } else {
                            if (data.registration != $("#REGISTRATION").val() && $("#REGISTRATION").val() != "") {
                                $(".invalid-feedback").html("Pallet Number ["+pallet_no+"] is under " + data.registration + " Registration.");
                            } else {
                                if (pallet_nos.includes(data.pallet_no)) {
                                    $(".invalid-feedback").html("Pallet Number ["+pallet_no+"] is already scanned.");
                                } else {
                                    $(".invalid-feedback").html("");

                                    pallets.push(data);
                                    pallet_nos.push(data.pallet_no);

                                    if ($("#REGISTRATION").val() == "") {
                                        $("#REGISTRATION").val(data.registration);
                                    }
                                }
                            }
                        }
                    }
                })
                .catch(err => console.log(err));
                event.target.value = "";
        },
        saveCabinet() {
            let data = {};
            data['cabinet'] = $("#input-form").serializeArray();
            data['pallets'] = this.pallets;
            data['user_id'] = this.user_id;

            fetch('/api/mes/cabinet/save', {
                method: 'post',
                body: JSON.stringify(data),
                headers: {
                    'content-type': 'application/json'
                }
                })
                .then(res => res.json())
                .then(data => {
                    if (data != "Success") {
                        alert(data);
                    } else {
                        alert("Cabinet created.");
                        this.listCabinets();
                        this.createCabinet();
                    }
                })
                .catch(err => console.log(err));
        },
        selectCabinet: function(event) {
            if (this.cabinets_selected != undefined) {
                if (this.cabinets_selected.includes(event.target.value)) {
                    this.cabinets_selected.pop(event.target.value);
                } else {
                    this.cabinets_selected.push(event.target.value);
                }
            } else {
                this.cabinets_selected.push(event.target.value);
            }
        },
        shipCabinets() {
            let ship_details = $("#ship-details").serializeArray();
            let vm = this;
            let error = "";

            $.each(ship_details, function(i) {
                if (this.value == "") {
                    error = "This field is required."
                    $("#"+this.name).addClass("is-invalid").removeClass("is-valid");
                    $("#err_"+this.name).html(error);
                    return false;
                } else {
                    $("#"+this.name).removeClass("is-invalid").addClass("is-valid");
                    $("#err_"+this.name).html("");
                }
            });

            if (error == "") {
                let data = {};

                data['ship_details'] = ship_details;
                data['cabinets_selected'] = vm.cabinets_selected;

                fetch('/api/mes/cabinet/ship', {
                    method: 'put',
                    body: JSON.stringify(data),
                    headers: {
                        'content-type': 'application/json'
                    }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data > 0) {
                            vm.cabinets_selected = [];
                            alert("Selected Cabinet/s as marked as shipped.");
                            this.listCabinets();
                            $("#ShipModal").modal('toggle');
                        } else {
                            alert("No record was updated.");
                        }
                    })
                    .catch(err => console.log(err));
            }
        }
    }
}
</script>
