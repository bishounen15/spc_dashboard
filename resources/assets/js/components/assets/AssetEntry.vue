<template>
    <div>
        <div class="row mb-3">
            <div class="col-sm">
                <h3><i v-bind:class="{ 'fas fa-plus' : add, 'far fa-edit' : !add }"></i> {{add ? "Create" : "Edit"}} Asset Record</h3>
            </div>
            <div class="col-sm text-right">
                <button class="btn btn-success" @click="saveAsset()" :disabled="hasError"><i class="fas fa-save"></i> {{add ? "Save" : "Update"}} Record</button>
            </div>
        </div>

        <div class="row">
            <div class="col-sm">
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <a class="nav-link" v-bind:class="{ 'active' : current_tab == 'general' }" href="#" @click="changeTab('general')">General Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" v-bind:class="{ 'active' : current_tab == 'specs' }" href="#" @click="changeTab('specs')">Specifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" v-bind:class="{ 'active' : current_tab == 'network' }" href="#" @click="changeTab('network')" hidden>Network</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" v-bind:class="{ 'active' : current_tab == 'disks' }" href="#" @click="changeTab('disks')" hidden>Disks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" v-bind:class="{ 'active' : current_tab == 'software' }" href="#" @click="changeTab('software')" hidden>Software</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container-fluid bg-white">
            <div class="row">
                <div class="col-sm">
                    <div :hidden="current_tab != 'general'" class="form mt-3">
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="type">Equipment Type</label>
                                    </div>
                                    
                                    <div class="col-sm">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" value="Laptop" v-model="record.type" @change="rbChange">
                                        <label class="form-check-label" for="inlineRadio1">Laptop</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" value="Desktop" v-model="record.type" @change="rbChange">
                                        <label class="form-check-label" for="inlineRadio2">Desktop</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="brand">Brand</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="brand" placeholder="Enter device brand name" :readonly="!add" v-model="record.brand">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="model">Model</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="model" placeholder="Enter device model name" :readonly="!add" v-model="record.model">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="serial">Serial Number</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control form-danger" name="serial" placeholder="Enter device serial number" :readonly="!add" @blur="checkSerial" v-model="record.serial">
                                        <span class="form-text text-danger">{{error_msg}}</span>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="os">Operating System</label>
                                    </div>
                                    <div class="col-sm">
                                        <textarea class="form-control" name="os" placeholder="Enter Operating System" :readonly="!add" v-model="record.os"></textarea>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="site">Site</label>
                                    </div>
                                    <div class="col-sm">
                                        <select class="form-control" name="site" @click="siteLookup" v-model="record.site">
                                            <option value="" disabled selected>-- Select site --</option>
                                            <option v-for="(site,index) in sites" v-bind:key="index" v-bind:value="site.descr">{{ site.descr }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="sub_site">Sub site</label>
                                    </div>
                                    <div class="col-sm">
                                        <select class="form-control" name="sub_site" :disabled="sub_sites.length==0" v-model="record.sub_site">
                                            <option value="" disabled selected>-- Select sub site --</option>
                                            <option v-for="(site,index) in sub_sites" v-bind:key="index" v-bind:value="site.descr">{{ site.descr }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm">
                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="host_name">Host Name</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="host_name" placeholder="Enter device host name" v-model="record.host_name">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="id_number">Employee ID Number</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="id_number" placeholder="Enter ID Number of Assignee" v-model="record.id_number">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="name" placeholder="Enter Employee Name" v-model="record.name">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="dept">Department</label>
                                    </div>
                                    <div class="col-sm">
                                        <select class="form-control" name="dept" v-model="record.dept">
                                            <option value="" disabled selected>-- Select Department --</option>
                                            <option v-for="(dept,index) in depts" v-bind:key="index" v-bind:value="dept">{{ dept }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="status">Property Type</label>
                                    </div>
                                    
                                    <div class="col-sm">
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="Owned" v-model="record.status">
                                        <label class="form-check-label" for="inlineRadio1">Owned</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="Leased" v-model="record.status">
                                        <label class="form-check-label" for="inlineRadio2">Leased</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="device_status">Status</label>
                                    </div>
                                    <div class="col-sm">
                                        <select class="form-control" name="device_status" v-model="record.device_status">
                                            <option value="" disabled selected>-- Select Status --</option>
                                            <option v-for="(status,index) in statuses" v-bind:key="index" v-bind:value="status">{{ status }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="remarks">Remarks</label>
                                    </div>
                                    <div class="col-sm">
                                        <textarea class="form-control" name="remarks" placeholder="Enter Remarks / Notes" v-model="record.remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div :hidden="current_tab != 'specs'" class="mt-3">
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="proc">Processor</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="proc" placeholder="Enter Processor Details" v-model="record.proc">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="hdd">Storage</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="hdd" placeholder="Enter Total Storage Capacity" v-model="record.hdd">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="ram">Total Memory</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="ram" placeholder="Enter Total Memory" v-model="record.ram">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="gfx_card">Graphics Card</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="gfx_card" placeholder="Enter Graphics Card Info" v-model="record.gfx_card">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm">

                            </div>
                        </div>
                    </div>

                    <div :hidden="current_tab != 'network'" class="mt-3">
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="ip">IP Address</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="ip" placeholder="Enter IP Address">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="mac">MAC Address</label>
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" name="mac" placeholder="Enter MAC Address">
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-sm">
                                        <label for="interface">Interface</label>
                                    </div>
                                    <div class="col-sm">
                                        <select class="form-control" name="interface">
                                            <option value="" disabled selected>-- Select Interface --</option>
                                            <option v-for="(ni,index) in net_intefaces" v-bind:key="index" v-bind:value="ni">{{ ni }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm">
                                        <button class="btn btn-success btn-block">Save</button>
                                    </div>

                                    <div class="col-sm">
                                        <button class="btn btn-secondary btn-block">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <table class="table table-condensed table-striped table-dark">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>IP Address</th>
                                            <th>MAC Address</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Interface</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div :hidden="current_tab != 'disks'" class="mt-3">
                        Disks
                    </div>

                    <div :hidden="current_tab != 'software'" class="mt-3">
                        Software
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getSites();

        if (this.add) {
            this.record.type = "Laptop";
            this.record.status = "Owned";
        } else {
            // console.log(this.record.serial = this.device_id);
            this.getDetails(this.device_id);
        }
    },
    data() {
        return {
            current_tab: "general",
            departments: {
                factory: ["Admin", "Equipment Engineering", "Facilities", "Finance", "Human Resources", "Information Technology","OEM", "Planning", "Process Engineering", "Production", "Purchasing", "Quality", "Sales", "Warehouse and Logistics",],
                corporate: ["Construction", "Corporate Business Sales", "Design Technology", "Domestic Business Development", "Finance", "HR and Admin", "Information Technology", "International Business Development", "Land Acquisition", "Legal Affairs", "ManCom", "Marketing", "Permitting and Compliance", "Plant Management", "Project Development", "Quality", "Regional Sales", "Regulatory", "Rooftop Sales", "Sales Operation", "Supply Chain",],
            },
            sites: [],
            sub_sites: [],
            depts: [],
            statuses: ["Deployed","In-Stock","Vendor Repair","Retired",],
            net_intefaces: ["Ethernet","Wireless80211"],
            record: {
                type: '',
                brand: '',
                model: '',
                serial: '',
                os: '',
                site: '',
                sub_site: '',
                host_name: '',
                proc: '',
                hdd: '',
                ram: '',
                gfx_card: '',
                id_number: '',
                name: '',
                dept: '',
                status: '',
                device_status: '',
                remarks: '',
                // network: [],
                // disks: [],
                // software: [],
            },
            hasError: false,
            error_msg: '',
        }
    }, 
    created() {
        
    },
    props: {
        add: Boolean,
        device_id: Number,
    },
    methods: {
        changeTab(tab) {
            this.current_tab = tab;
        },
        rbChange: function(e) {
            // console.log(this.record.type);
        },
        siteLookup: function(e) {
            this.getSites(e.target.value);
            let ix = e.target.selectedIndex;
            let selected_site = e.target.options[ix].text;

            let vm = this;

            if (selected_site == 'Factory') {
                vm.depts = vm.departments.factory;
            } else {
                vm.depts = vm.departments.corporate;
            }
        },
        getSites(site_id) {
            let mysite =  site_id || '';
            let vm = this;

            fetch('/api/asset/sites/' + mysite , {
                method: 'post'
                })
                .then(res => res.json())
                .then(res => {
                    if (mysite == '') {
                        vm.sites = res;
                    } else {
                        vm.sub_sites = res;
                    }
                })
                .catch(err => console.log(err));
        },
        saveAsset() {
            let vm = this;

            if (vm.record.dept == "") {
                vm.record.dept = "-";
            }

            fetch('/api/asset/update', {
                method: 'post',
                body: JSON.stringify(this.record),
                headers: {
                    'content-type': 'application/json'
                }
                })
                .then(res => res.json())
                .then(res => {
                    alert("Record "+ (vm.add ? "created" : "updated") +".");
                    window.location.href = '/assets/general';
                })
                .catch(err => console.log(err));
        },
        checkSerial: function(e) {
            if (add) {
                let vm = this;

                fetch('/api/asset/check/' + e.target.value, {
                    method: 'post'
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res != "") {
                            vm.hasError = true;
                        } else {
                            vm.hasError = false;
                        }

                        vm.error_msg = res;
                        console.log(vm.error_msg);
                    })
                    .catch(err => console.log(err));
            }
        },
        getDetails(id) {
            let vm = this;

            fetch('/api/asset/get/' + id , {
                method: 'post'
                })
                .then(res => res.json())
                .then(res => {
                    vm.record.serial = res.serial;
                    vm.record.type = res.type;
                    vm.record.status = res.status;
                    vm.record.brand = res.brand;
                    vm.record.model = res.model;
                    vm.record.os = res.os;
                    vm.record.site = res.site;
                    vm.getSites(res.site);
                    vm.record.sub_site = res.sub_site;
                    vm.record.host_name = res.host_name;
                    vm.record.id_number = res.id_number;
                    vm.record.name = res.name;
                    if (res.site == 'Factory') {
                        vm.depts = vm.departments.factory;
                    } else {
                        vm.depts = vm.departments.corporate;
                    }
                    vm.record.dept = res.dept;
                    vm.record.device_status = res.device_status;
                    vm.record.remarks = res.remarks;
                    vm.record.proc = res.proc;
                    vm.record.hdd = res.hdd;
                    vm.record.ram = res.ram;
                    vm.record.gfx_card = res.gfx_card;
                })
                .catch(err => console.log(err));
        }
    }
}
</script>