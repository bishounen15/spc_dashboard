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
                        <button id="AddRecord" class="btn btn-info" @click="createCabinet()">
                            Add Record
                        </button>
                    </div>
                    <div class="col-sm pt-0 pb-2 pl-1 pr-3 text-right">
                        <button id="ShipCabinet" class="btn btn-success pull-right">
                            Marked as Shipped
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
                                <td>{{i+1}}</td>
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
            max_pallets: 16
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
        listCabinets() {
            fetch('/api/mes/cabinet/list', {
                method: 'post',
                })
                .then(res => res.json())
                .then(data => {
                    this.cabinets = data.data;
                    console.log(this.cabinets);
                })
                .catch(err => console.log(err));
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
        }
    }
}
</script>
