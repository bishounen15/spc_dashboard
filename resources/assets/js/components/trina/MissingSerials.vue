<template>
    <div>
        <h3><i class="fas fa-info-circle"></i> TRINA Missing Serial Numbers</h3>
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <label class="my-1 mr-2" for="tdate">Date</label>
                    <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="tdate" id="tdate" v-model="date" @change="getList()" :disabled="loading==true">
                    
                    <button type="submit" class="btn btn-success my-1" id="SyncButton" @click="syncSerials()" :disabled="loading==true || (list.length == 0 || list == undefined)"><i class="fas fa-sync"></i> Sync Serials</button>
                </div>
            </div>
        </div>
        <table class="table table-condensed table-striped table-sm" id="mod-list" style="width: 100%;">
            <thead class="thead-dark" style="font-size: 0.7em;">
                <th>Module ID</th>
                <th>Order ID</th>
                <th>Work Order ID</th>
                <th>Version</th>
                <th>Product ID</th>
                <th>Product Type</th>
                <th>Creation Date</th>
                <th>Synced in Web Portal</th>
            </thead>
            <tbody class="tbody-light" style="font-size: 0.75em;">
                <tr v-if="loading">
                    <td colspan="8" class="text-center table-warning">
                        <h4>Loading Data. Please Wait...</h4>
                    </td>
                </tr>
                <tr v-else-if="syncing">
                    <td colspan="8" class="text-center table-info">
                        <h4>Syncing Module IDs. Please Wait...</h4>
                    </td>
                </tr>
                <tr v-else-if="list.length == 0 || list == undefined">
                    <td colspan="8" class="text-center">
                        No Record Found
                    </td>
                </tr>
                <tr v-for="(data,i) in list" v-bind:key="i" v-else>
                    <td>{{data.Module_ID}}</td>
                    <td>{{data.OrderID}}</td>
                    <td>{{data.WorkOrder_ID}}</td>
                    <td>{{data.WorkOrder_vertion}}</td>
                    <td>{{data.Product_ID}}</td>
                    <td>{{data.Product_Type}}</td>
                    <td>{{data.Create_Date}}</td>
                    <td>{{data.Synced}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    mounted() {
        if (this.date == '') {
            this.date = this.def_date;
        }
    },
    data() {
        return {
            list: [],
            loading: false,
            syncing: false,
            date: '',
        }
    }, 
    created() {
        this.getList();
    },
    props: {
        def_date: String,
    },
    methods: {
        getList() {
            let vm = this;
            let uri = ('/api/trina/missing/' + vm.date);
            vm.loading = true;
            
            fetch(uri, {
                method: 'post',
                })
                .then(res => res.json())
                .then(res => {
                    vm.list = res;
                    vm.loading = false;
                })
                .catch(err => {
                    vm.loading = false;
                });
        },
        syncSerials() {
            let vm = this;

            if (vm.list.length == 0 || vm.list == undefined) {
                alert("There are no serials for sync.");
            } else {
                let mydata = {};
                mydata['params'] = JSON.stringify(JSON.stringify(vm.list));

                vm.syncing = true;

                fetch('/api/trina/syncmid', {
                    method: 'post',
                    body: JSON.stringify(mydata),
                    headers: {
                        'content-type': 'application/json'
                    }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data == "") {
                            alert("Sync Success.");
                            vm.getList();
                        } else {
                            alert("Sync Failed: " + data);
                        }

                        vm.syncing = false;
                    })
                    .catch(err => {
                        alert("Error: " + err);
                        vm.syncing = false;
                    });
            }
        }
    }
}
</script>