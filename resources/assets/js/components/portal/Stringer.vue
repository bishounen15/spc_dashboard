<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Production Line</label>
                            <input type="text" class="form-control" name="" id="" readonly>
                        </div>
                    </div>

                    <div class="col-sm">
                        <label for="">Machine</label>
                        <input type="text" class="form-control" name="" id="" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#" id="lot-tab" class="nav-link" v-bind:class="active_tab == 'lot-tab' ? 'active' : ''" @click="changeTab">Lot IDs</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" id="sno-tab" class="nav-link" v-bind:class="active_tab == 'sno-tab' ? 'active' : ''" @click="changeTab">Serial Number</a>
                    </li>
                </ul>
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
            active_tab: 'lot-tab',
        }
    },
    methods: {
        changeTab: function(event) {
            this.active_tab = event.target.id;
        }
    }
}
</script>