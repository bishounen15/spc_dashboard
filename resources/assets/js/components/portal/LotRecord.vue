<template>
    <div>
        <h3 class="mb-4">{{station}} Lot Transaction [{{line_desc}}]</h3>
        <div class="card">
            <div class="card-header">Lot Number Recording</div>
            <div class="card-body pt-0 pb-0 pl-1 pr-1">
                <div class="form-row">
                    <div class="col-sm-6 p-3">
                        <div class="form-row" v-for="(column,i) in materials" v-bind:key="i">
                            <div class="col-sm-6">
                                <small>{{column.caption}} Lot Number</small>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" v-bind:name="column.field" v-bind:id="column.field" class="form-control form-control-sm" v-bind:data-index="column.index" :autofocus="column.index==1" v-on:keyup.13="pushEnter" v-on:focusout="pushEnter" placeholder="Scan Lot Number Here">
                                    <div :id="'err_'+column.field" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 p-3">
                        <div class="form-group">
                            <label for="SERIALNO">Module Serial Number</label>
                            <input type="text" name="SERIALNO" id="SERIALNO" class="form-control" v-on:keyup.13="save" placeholder="Scan Serial Number here">
                            <div id="err_SERIALNO" class="invalid-feedback"></div>
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
        $("#err_SERIALNO").show();
    },
    data() {
        return {
            no_lot: 0
        }
    },
    created() {
        
    },
    props: {
        station: String,
        materials: Array,
        production_line: Number,
        line_desc: String
    },
    methods: {
        pushEnter: function(event) {
            let index = event.target.getAttribute('data-index');
            let nextObject = $("#LOT0"+(parseInt(index)+1));
            
            if (event.target.value == "") {
                if ($("#" + event.target.name).hasClass("is-invalid") == false) {
                    $("#" + event.target.name).addClass("is-invalid").removeClass("is-valid");
                    $("#err_" + event.target.name).html("Lot number is required.");
                    this.no_lot++;
                }
            } else {
                if ($("#" + event.target.name).hasClass("is-valid") == false) {
                    $("#" + event.target.name).removeClass("is-invalid").addClass("is-valid");
                    $("#err_" + event.target.name).html("");
                    this.no_lot--;
                }
            }
            
            if (event.type != "focusout") {
                if (nextObject.val()==undefined) {
                    $("#SERIALNO").focus();
                } else {
                    nextObject.focus();
                }
            }
        },
        save: function(event) {
            if (this.no_lot > 0) {
                $("#err_" + event.target.name).html("All lot number fields are required. (" + this.no_lot + " empty lot number/s)");
            } else {
                if (event.target.value == "") {
                    $("#err_" + event.target.name).html("Please scan a serial number.");
                } else {
                    let formData = new FormData();
                    formData.append('serial', event.target.value);
                    formData.append('station', this.station);

                    axios.post( '/mes/validate',
                    formData
                    ).then(function(response){
                        $("#err_" + event.target.name).html(response.data.errors.error_msg);
                    })
                    .catch(function(err){
                        console.log(err);
                    });
                }
            }
        }
    }
}
</script>

