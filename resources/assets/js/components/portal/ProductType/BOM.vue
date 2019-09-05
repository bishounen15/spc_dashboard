<template>
    <div>
        <h3 class="mb-3"><i class="fas fa-tasks"></i> BOM Maintenance</h3>
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header">
                        Product Type Selection
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="PRODTYPE">Product Type</label>
                            <select name="PRODTYPE" id="PRODTYPE" class="form-control" @change="setProductType">
                                <option readonly selected value> -- Select a product type -- </option>
                                <option v-for="(option, i) in product_types" v-bind:key="i" v-bind:value="option.value">{{option.caption}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="CUSTOMER">Supplier</label>
                            <input type="text" name="CUSTOMER" id="CUSTOMER" class="form-control" v-bind:value="product_type.CUSTOMER" readonly>
                        </div>

                        <div class="form-group">
                            <label for="CELLCOUNT">Cell Count</label>
                            <input type="text" name="CELLCOUNT" id="CELLCOUNT" class="form-control" v-bind:value="product_type.CELLCOUNT" readonly>
                        </div>

                        <div class="form-group">
                            <label for="CELLCOLOR">Cell Type</label>
                            <input type="text" name="CELLCOLOR" id="CELLCOLOR" class="form-control" v-bind:value="product_type.CELLCOLOR" readonly>
                        </div>

                        <div class="form-group">
                            <label for="SERIALFORMAT">Serial Number Format</label>
                            <input type="text" name="SERIALFORMAT" id="SERIALFORMAT" class="form-control" v-bind:value="product_type.SERIALFORMAT" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-header">
                        Components
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#" id="rawmat" class="nav-link" v-bind:class="active_tab == 'rawmat' ? 'active' : ''" @click="changeTab">Raw Materials</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" id="packaging" class="nav-link" v-bind:class="active_tab == 'packaging' ? 'active' : ''" @click="changeTab">Packaging Materials</a>
                            </li>
                        </ul>

                        <div class="card" id="rawmats" v-bind:class="active_tab == 'rawmat' ? 'tab-visible' : 'tab-hidden'">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col"></div>
                                    <div class="col-sm text-right">
                                        <button class="btn btn-sm btn-success" name="rawmat" @click="addComponent" :disabled="!bom.product_type"><i class="fas fa-plus"></i> Add Component</button>
                                    </div>
                                </div>
                                <table class="table table-sm table-condensed table-bordered" id="rawmat-table">
                                    <thead class="thead-dark" style="font-size: 0.7em;">
                                        <th>Item Category</th>
                                        <th>Item Number</th>
                                        <th>Item Description</th>
                                        <th>Usage</th>
                                        <th>UOFM</th>
                                        <th>Supplier</th>
                                    </thead>
                                    <tbody style="font-size: 0.7em;">
                                        <tr v-if="bom.raw_materials.length == 0">
                                            <td colspan="6" class="text-center">No Raw Material Components</td>
                                        </tr>
                                        <tr v-for="(row, i) in bom.raw_materials" v-bind:key="i" v-else>
                                            <td class="align-middle" :rowspan="row.rowspan" v-if=" !i ? true : bom.raw_materials[i-1].bom_index == bom.raw_materials[i].bom_index ? '' :true ">{{row.item_class}}</td>
                                            <td>{{row.item_code}}</td>
                                            <td>{{row.item_desc}}</td>
                                            <td class="align-middle" :rowspan="row.rowspan" v-if=" !i ? true : bom.raw_materials[i-1].bom_index == bom.raw_materials[i].bom_index ? '' :true ">{{row.bom_qty}}</td>
                                            <td class="align-middle" :rowspan="row.rowspan" v-if=" !i ? true : bom.raw_materials[i-1].bom_index == bom.raw_materials[i].bom_index ? '' :true ">{{row.uofm_base}}</td>
                                            <td>{{row.supplier}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card" id="packaging" v-bind:class="active_tab == 'packaging' ? 'tab-visible' : 'tab-hidden'">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm">
                                        <h5><strong>Box Packaging</strong></h5>
                                    </div>
                                    <div class="col-sm text-right">
                                        <button class="btn btn-sm btn-success" name="box packaging" @click="addComponent" :disabled="!bom.product_type"><i class="fas fa-plus"></i> Add Component</button>
                                    </div>
                                </div>
                                <table class="table table-sm table-condensed mb-3" id="box-table">
                                    <thead class="thead-dark" style="font-size: 0.7em;">
                                        <th>Item Category</th>
                                        <th>Item Number</th>
                                        <th>Item Description</th>
                                        <th>Usage</th>
                                        <th>UOFM</th>
                                        <th>Supplier</th>
                                    </thead>
                                    <tbody style="font-size: 0.7em;">
                                        <tr v-if="bom.packaging_materials.box_packaging.components.length == 0">
                                            <td colspan="6" class="text-center">No Box Packaging Components</td>
                                        </tr>
                                        <tr v-for="(row, i) in bom.packaging_materials.box_packaging.components" v-bind:key="i" v-else>
                                            <td>{{row.item_class}}</td>
                                            <td>{{row.item_code}}</td>
                                            <td>{{row.item_desc}}</td>
                                            <td>{{row.bom_qty}}</td>
                                            <td>{{row.uofm_base}}</td>
                                            <td>{{row.supplier}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row mb-2">
                                    <div class="col-sm">
                                        <h5><strong>Horizontal Packaging</strong></h5>
                                    </div>
                                    <div class="col-sm text-right">
                                        <button class="btn btn-sm btn-success" name="horizontal packaging" @click="addComponent" :disabled="!bom.product_type"><i class="fas fa-plus"></i> Add Component</button>
                                    </div>
                                </div>
                                <table class="table table-sm table-condensed mb-3" id="horizontal-table">
                                    <thead class="thead-dark" style="font-size: 0.7em;">
                                        <th>Item Category</th>
                                        <th>Item Number</th>
                                        <th>Item Description</th>
                                        <th>Usage</th>
                                        <th>UOFM</th>
                                        <th>Supplier</th>
                                    </thead>
                                    <tbody style="font-size: 0.7em;">
                                        <tr v-if="bom.packaging_materials.horizontal_packaging.components.length == 0">
                                            <td colspan="6" class="text-center">No Horizontal Packaging Components</td>
                                        </tr>
                                        <tr v-for="(row, i) in bom.packaging_materials.horizontal_packaging.components" v-bind:key="i">
                                            <td>{{row.item_class}}</td>
                                            <td>{{row.item_code}}</td>
                                            <td>{{row.item_desc}}</td>
                                            <td>{{row.bom_qty}}</td>
                                            <td>{{row.uofm_base}}</td>
                                            <td>{{row.supplier}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="input-form" @submit.prevent="saveRecord()">
            <div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Component : {{active_tab == "rawmat" ? "Raw" : "Packaging"}} Materials</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="item_class">Item Class</label>
                                    <input type="hidden" name="product_type" v-bind:value="bom.product_type">
                                    <input type="hidden" name="category" v-bind:value="bom.category">
                                    <select name="item_class" id="item_class" class="form-control form-control-sm input-field" @change="changeItemClass">
                                        <option readonly selected value> -- Select an item class -- </option>
                                        <option v-for="(option, i) in item_classes" v-bind:key="i" v-bind:value="option.value">{{option.caption}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="filter_item">Filter Items</label>
                                    <input type="text" name="filter_item" id="filter_item" class="form-control form-control-sm input-field" @keypress="filterItems">
                                </div>

                                <div class="form-group">
                                    <label for="bom_qty">Usage</label>
                                    <input type="number" name="bom_qty" id="bom_qty" class="form-control form-control-sm input-field" step=".00001">
                                </div>
                            </div>

                            <div class="col-sm-8 bg-light">
                                <div class="row">
                                    <div class="col-sm">
                                        <label for="">Item List</label>
                                    </div>
                                    <div class="col-sm text-right" v-if="items.length > 0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="mark-all" id="mark-all" :disabled="items.length < 2" @change="toggleMark">
                                            <label class="form-check-label" for="defaultCheck1">
                                                Mark All
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center" v-if="items.length == 0">
                                        <h5>No Item Found</h5>
                                    </div>
                                    <div class="col-sm-6" v-for="(option, i) in items" v-bind:key="i" v-bind:value="option.value" v-else>
                                        <div class="form-check">
                                            <input class="form-check-input item-list" type="checkbox" v-bind:value="option.value" name="selected_items[]">
                                            <label class="form-check-label" for="defaultCheck1">
                                                {{option.value}} <br>
                                                <small>{{option.caption}}</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- @click="clearInput()" -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="clearModal()">Close</button>
                        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Save changes</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<style>
    .tab-visible {
        display: block;
    }

    .tab-hidden {
        display: none;
    }
</style>

<script>
export default {
    mounted() {
        this.getProductTypes();
    },
    data() {
        return {
            active_tab: "rawmat",
            product_types: [],
            item_classes: [],
            items: [],
            product_type: {},
            bom: {
                product_type: '',
                category: '',
                raw_materials: [],
                packaging_materials: {
                    box_packaging: {
                        max_modules: 0,
                        components: [],
                    },
                    horizontal_packaging: {
                        max_modules: 0,
                        components: [],
                    },
                }
            },
        }
    },
    created() {
        
    },
    methods: {
        changeTab: function(event) {
            this.active_tab = event.target.id;
        },
        getProductTypes() {
            let vm = this;

            fetch('/api/prodtype/lookup', {
                    method: 'post',
                    })
                    .then(res => res.json())
                    .then(data => {
                        let list = [];
                        $.each(data.data, function(i) {
                            list.push(this);
                        });
                        vm.product_types = list;
                    })
                    .catch(err => console.log(err));
        },
        setProductType: function(event) {
            let vm = this;
            
            fetch('/api/prodtype/details/' + event.target.value, {
                    method: 'post',
                    })
                    .then(res => res.json())
                    .then(data => {
                        vm.product_type = data.data;
                        vm.bom.product_type = event.target.value;
                        this.getBOM(event.target.value);
                    })
                    .catch(err => console.log(err));
        },
        getBOM(product_type) {
            let vm = this;
            
            fetch('/api/planning/bom/details/' + product_type, {
                    method: 'post',
                    })
                    .then(res => res.json())
                    .then(data => {
                        vm.bom.raw_materials = data.rm;
                        vm.bom.packaging_materials.box_packaging.components = data.pk;
                        vm.bom.packaging_materials.horizontal_packaging.components = data.hr;
                    })
                    .catch(err => console.log(err));
        },
        addComponent: function(event) {
            let vm = this;
            
            fetch('/api/itemclass/lookup/' + vm.active_tab, {
                    method: 'post',
                    })
                    .then(res => res.json())
                    .then(data => {
                        vm.bom.category = event.target.name;
                        vm.item_classes = data.data;
                        $("#AddModal").modal("toggle");
                    })
                    .catch(err => console.log(err));
        },
        changeItemClass: function(event) {
            let vm = this;
            
            fetch('/api/item/lookup/' + event.target.value, {
                    method: 'post',
                    })
                    .then(res => res.json())
                    .then(data => {
                        vm.unmarkItems();
                        vm.items = data.data;
                    })
                    .catch(err => console.log(err));
        },
        filterItems: function(event) {
            if (event.which == 13) {
                event.preventDefault();
                let vm = this;
            
                fetch('/api/item/lookup/' + $('#item_class').val() + '/' + event.target.value, {
                        method: 'post',
                        })
                        .then(res => res.json())
                        .then(data => {
                            vm.unmarkItems();
                            vm.items = data.data;
                        })
                        .catch(err => console.log(err));
            }
        },
        clearModal() {
            $('.input-field').val("");
            this.items = [];
            this.unmarkItems();
        },
        toggleMark: function(event) {
            let value = $("#" + event.target.id).prop('checked');
            $(".item-list").prop('checked', value);
        },
        unmarkItems() {
            $("#mark-all").prop('checked',false);
            $(".item-list").prop('checked', false);
        },
        saveRecord() {
            let vm = this;
            let data = {};
            data = $("#input-form").serializeArray();

            let params = {};

            params['data'] = data;
            params['user_id'] = '-';

            fetch('/api/planning/bom/add', {
                    method: 'post',
                    body: JSON.stringify(params),
                    headers: {
                        'content-type': 'application/json'
                    }
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (data != "") {
                            alert(data);
                        } else {
                            this.getBOM(vm.bom.product_type);
                            this.clearModal();
                            $("#AddModal").modal('toggle');
                        }
                    })
                    .catch(err => console.log(err));

            // alert('Saved');
            // $("#AddModal").modal('toggle');
        }
    }
}
</script>