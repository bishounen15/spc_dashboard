<template>
    <div>
        <h3 class="mb-3"><i class="fas fa-box-open"></i> Lot ID Assignment</h3>
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header">
                        Parent Lot Details
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="parent_lot">Enter Parent Lot ID</label>
                            <input type="text" class="form-control" name="parent_lot" id="parent_lot" v-on:keyup.13="getDetails">
                        </div>

                        <div>
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <th width="25%" class="table-dark">Parent Lot</th>
                                        <td width="75%"><h3>{{parent_lot.lot_id}}</h3></td>
                                    </tr>

                                    <tr>
                                        <th class="table-dark">Part Number</th>
                                        <td>{{parent_lot.part_number}}</td>
                                    </tr>

                                    <tr>
                                        <th class="table-dark">Description</th>
                                        <td><small>{{parent_lot.description}}</small></td>
                                    </tr>

                                    <tr>
                                        <th class="table-dark">Efficiency</th>
                                        <td>{{parent_lot.efficiency}}</td>
                                    </tr>

                                    <tr>
                                        <th class="table-dark">Quantity</th>
                                        <td>{{parent_lot.qty}}</td>
                                    </tr>

                                    <tr>
                                        <th class="table-dark">Qty per Pack</th>
                                        <td>{{parent_lot.issue_qty}}</td>
                                    </tr>

                                    <tr>
                                        <th class="table-dark">Balance Qty</th>
                                        <td>{{this.qtyRemaining}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header">
                        Child Lot IDs
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="child_lot">Enter Child Lot ID</label>
                                    <input type="text" class="form-control" name="child_lot" id="child_lot" :disabled="parent_lot.lot_id=='' || this.qtyRemaining==0" :readonly="saving==true" v-on:keyup.13="addChild">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="qty">Quantity <span v-if="parent_lot.issue_qty > child_qty">(Loose Qty)</span></label>
                                    <input type="number" step="0.00001" class="form-control" name="qty" id="qty" v-model="child_qty" v-bind:class="{'is-invalid' : (parent_lot.issue_qty < child_qty || child_qty <= 0  || qtyRemaining < child_qty)}" :disabled="parent_lot.lot_id=='' || this.qtyRemaining==0" v-on:keyup.13="addChild">
                                </div>
                            </div>
                        </div>
                        
                        <table class="table table-sm table-condensed table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="50%">Child Lot</th>
                                    <th width="25%">Quantity</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(lot,i) in parent_lot.child_lots" v-bind:key="i">
                                    <td>{{i+1}}</td>
                                    <td>{{lot.child_id}}</td>
                                    <td>{{lot.qty}}</td>
                                    <td><button class="btn btn-sm btn-danger" @click="removeChild(lot.child_id)"><i class="far fa-trash-alt"></i> Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
export default {
    mounted() {

    },
    data() {
        return {
            parent_lot: {
                lot_id: '',
                part_number: '',
                description: '',
                efficiency: '',
                qty: 0,
                issue_qty: 0,
                child_lots: []
            },
            child_qty: 0,
            saving: false,
        }
    },
    created() {

    },
    props: {

    },
    computed: {
        qtyRemaining: function() {
            let total = 0;

            $.each(this.parent_lot.child_lots, function() {
                total += this.qty;
            });

            return this.parent_lot.qty - (total);
        }
    },
    methods: {
        getDetails: function(event) {
            let vm = this;
            
            if (event.target.value != '') {
                fetch('/api/mes/lot/info/' + event.target.value, {
                    method: 'get',
                    })
                    .then(res => res.json())
                    .then(data => {
                        event.target.value = '';
                        let pl = vm.parent_lot;
                        if (data.parent_lot.length > 0) {
                            let details = data.parent_lot[0];

                            pl.lot_id = details.lot_id;
                            pl.part_number = details.part_number;
                            pl.description = details.description;
                            pl.efficiency = details.efficiency;
                            pl.qty = details.qty;
                            pl.issue_qty = details.issue_qty;

                            pl.child_lots = data.child_lot;

                            this.setDefaults();
                        } else {
                            pl.lot_id = '';
                            pl.part_number = '';
                            pl.description = '';
                            pl.efficiency = '';
                            pl.qty = '';
                            pl.issue_qty = '';
                            pl.child_lots = [];
                        }
                    })
                    .catch(err => console.log(err));
            }
        },
        getChild(parent) {
            let vm = this;
            
            if (parent != '') {
                fetch('/api/mes/lot/info/' + parent, {
                    method: 'get',
                    })
                    .then(res => res.json())
                    .then(data => {
                        let pl = vm.parent_lot;
                        if (data.parent_lot.length > 0) {
                            let details = data.parent_lot[0];
                            pl.child_lots = data.child_lot;
                        } else {
                            pl.child_lots = [];
                        }
                    })
                    .catch(err => console.log(err));
            }
        },
        addChild: function(event) {
            let vm = this;
            
            if (event.target.value != '') {
                if (vm.parent_lot.issue_qty < vm.child_qty) {
                    alert('Quantity should not exceed Qty per Pack.');
                } else if (vm.child_qty <= 0) {
                    alert('Quantity should be greater than zero (0).');
                } else if (vm.qtyRemaining < vm.child_qty) {
                    alert('You cannot exceed the Balance Quantity.');
                } else {
                    vm.saving = true;
                    fetch('/api/mes/lot/assign/' + vm.parent_lot.lot_id + '/' + event.target.value + '/' + vm.child_qty , {
                    method: 'post',
                    })
                    .then(res => res.json())
                    .then(data => {
                        event.target.value = '';
                        if (data.msg == '') {
                            this.getChild(vm.parent_lot.lot_id);
                            this.setDefaults();
                        } else {
                            alert(data.msg);
                        }

                        vm.saving = false;
                    })
                    .catch(err => {
                        vm.saving = false;
                        console.log(err);
                    });
                }
            }
        },
        removeChild(lot) {
            let vm = this;
            
            if (confirm('Deleting Lot ID ['+lot+']. Are You Sure?')) {
                fetch('/api/mes/lot/delete/' + lot , {
                method: 'delete',
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data.results);
                    // if (data.msg == '') {
                        this.getChild(vm.parent_lot.lot_id);
                        // this.setDefaults();
                    // } else {
                        // alert(data.msg);
                    // }
                })
                .catch(err => console.log(err));
            }
        },
        setDefaults() {
            this.child_qty = this.parent_lot.issue_qty;
        }
    }
}
</script>