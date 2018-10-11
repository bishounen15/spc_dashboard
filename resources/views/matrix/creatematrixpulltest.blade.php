@extends('layouts.app')

@section('content')
  
    <div class="container" style="width:120%">  
            {!! Form::open(['action' => 'MatrixPullTestsController@store', 'method' => 'POST']) !!}  
        <div class="card">
            <h5 class="card-header">Ribbon-to-Busbar Pull Test Data Inputs</h5>
        <div class="card-body">
                        <div class="jumbotron text-center">
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('employeeid', 'Employee ID:')}} </div>  
                                <div class="col-md-5"> {{ Form::text('employeeid', '',['class'=>'form-control'] )}} <small class="form-text text-danger">{{ $errors->first('employeeid') }}</small> </div>
                                <div class="col-md-1"> {{Form::label('processlbl', 'Process:')}}</div>  
                                <div class="col-md-5"> {{Form::select('process', array('Bussing1' => 'Bussing 1', 'Bussing2' => 'Bussing2','Rework' => 'Rework'),'',['class' => 'form-control process','placeholder' => 'Select Location'])}} <small class="form-text text-danger">{{ $errors->first('process') }}</small> </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('shift', 'Shift:')}} </div>  
                                <div class="col-md-5"> {{Form::select('shift', array('ShiftA' => 'Shift A', 'ShiftB' => 'Shift B', 'ShiftC' => 'Shift C'),'',['class' => 'form-control','placeholder' => 'Select Shift'])}} <small class="form-text text-danger">{{ $errors->first('shift') }}</small> </div>
                                <div class="col-md-1"> {{Form::label('node', 'Node:')}} </div>  
                                <div class="col-md-5"> {{ Form::text('node', 'Ribbon to Busbar',['class'=>'form-control'] )}} <small class="form-text text-danger">{{ $errors->first('node') }}</small> </div>
                            </div></br>
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('remarks', 'Remarks:')}} </div>
                                <div class="col-md-5"> {{Form::text('remarks','', ['class' => 'form-control','placeholder' => 'Remarks'])}} <small class="form-text text-danger">{{ $errors->first('remarks') }}</small> </div>
                                <div class="col-md-1"> {{Form::label('supplier', 'Supplier:')}} </div>
                                <div class="col-md-5"> {{Form::select('supplier', array('Gigastorage' => 'Gigastorage', 'YourBest' => 'YourBest'),'',['class' => 'form-control process','placeholder' => 'Select Supplier'])}} <small class="form-text text-danger">{{ $errors->first('supplier') }}</small> </div>            
                            </div></br>
                            <div class="row"> 
                                    
                                <div class="col-md-1"> {{Form::label('Date', 'Date:')}} </div>    
                                <div class="col-md-5"> {{Form::date('fixture_date', \Carbon\Carbon::now() ,['class'=>'form-control'] )}} </div>
                                <div class="col-md-1"> {{Form::label('ProdBuilt', 'Product Built:')}}</div>  
                                <div class="col-md-5">
                                      
                                    <?php  $getLastProd = DB::select("SELECT * FROM prodselect WHERE ProcessName ='Matrix Assembly' ORDER BY created_at DESC LIMIT 1 "); 
                                    $getProd = DB::select("SELECT * FROM producttype "); 
                                           $lastSet = "";
                                   ?>
                                     @if(count($getLastProd) > 0)
                                     @foreach($getLastProd as $field)   
                                            
                                    <?php $lastSet = $field->productName;  ?>
                                              @endforeach
                                              @else
                                              <?php $lastSet = "Not Set.";  ?>
                                              @endif  
                             
                            
                           
                               <select id="prodBuilt"  name="prodBuilt" class="form-control" >
                                       <option selected value="{{$lastSet}}">{{$lastSet}}</option>
                                               @foreach ($getProd as $s)
                                                       <option value="{{ $s->prodName }}">{{ $s->prodName }}</option> 
                                               @endforeach
                               </select> 
                               <small class="form-text text-danger">{{ $errors->first('prodBuilt') }}</small>  
                       
                                    
                                    
                                   
                                 
                                </div>
                            </div></br>
                        </div> 
                    </div>
                </div>
           
                        
                        <div class="card top1">
                        <h5 class="card-header">Top 1</h5>
                            <div class="card-body">
                            <div class="jumbotron text-center">
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('site1', 'Site 1:')}} </div>
                                <div class="col-md-3"> {{Form::text('pulltest1','', ['class' => 'form-control','placeholder' => 'PullTest1', 'id' => 'pulltest1', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('pulltest1') }}</small> </div> 
                                <div class="col-md-1"> {{Form::label('average', 'Average:')}} </div>
                                <div class="col-md-3"> {{Form::text('average','', ['class' => ' average form-control','placeholder' => 'Average', 'id' => 'average', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('average') }}</small> </div>     
                            </div></br> 
                            
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('site2', 'Site 2:')}} </div>
                                <div class="col-md-3"> {{Form::text('pulltest2','', ['class' => 'form-control','placeholder' => 'PullTest2', 'id' => 'pulltest2', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('pulltest2') }}</small> </div>     
                            </div></br> 

                            <div class="row">
                                <div class="col-md-1"> {{Form::label('site3', 'Site 3:')}} </div>
                                <div class="col-md-3"> {{Form::text('pulltest3','', ['class' => 'form-control','placeholder' => 'PullTest3', 'id' => 'pulltest3', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('pulltest3') }}</small> </div>     
                            </div></br>
                        </div>
                    </div>
                </div>
           

                            <div class="card top2">
                        <h5 class="card-header">Top 2</h5>
                            <div class="card-body">
                            <div class="jumbotron text-center">
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('twosite1', 'Site 1:')}} </div>
                                <div class="col-md-3"> {{Form::text('twopulltest1','', ['class' => 'form-control','placeholder' => 'PullTest1', 'id' => 'twopulltest1', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('twopulltest1') }}</small> </div> 
                                <div class="col-md-1"> {{Form::label('twoaverage', 'Average:')}} </div>
                                <div class="col-md-3"> {{Form::text('twoAverage','', ['class' => ' average form-control','placeholder' => 'Average', 'id' => 'twoAverage', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('twoaverage') }}</small> </div>     
                            </div></br> 
                            
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('twosite2', 'Site 2:')}} </div>
                                <div class="col-md-3"> {{Form::text('twopulltest2','', ['class' => 'form-control','placeholder' => 'PullTest2', 'id' => 'twopulltest2', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('twopulltest2') }}</small> </div>     
                            </div></br> 

                            <div class="row">
                                <div class="col-md-1"> {{Form::label('twosite3', 'Site 3:')}} </div>
                                <div class="col-md-3"> {{Form::text('twopulltest3','', ['class' => 'form-control','placeholder' => 'PullTest3', 'id' => 'twopulltest3', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('twopulltest3') }}</small> </div>     
                            </div></br>
                        </div>
                    </div>
                </div>
                     
                <div class="card top">
                    <h5 class="card-header">Top</h5>
                        <div class="card-body">
                        <div class="jumbotron text-center">
                        <div class="row">
                            <div class="col-md-1"> {{Form::label('topsite1', 'Site 1:')}} </div>
                            <div class="col-md-3"> {{Form::text('toppulltest1','', ['class' => 'form-control','placeholder' => 'PullTest1', 'id' => 'toppulltest1', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest1') }}</small> </div> 
                            <div class="col-md-1"> {{Form::label('botaverage', 'Average:')}} </div>
                            <div class="col-md-3"> {{Form::text('topaverage','', ['class' => ' average form-control','placeholder' => 'Average', 'id' => 'topaverage', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botaverage') }}</small> </div>     
                        </div></br> 
                        
                        <div class="row">
                            <div class="col-md-1"> {{Form::label('botsite2', 'Site 2:')}} </div>
                            <div class="col-md-3"> {{Form::text('toppulltest2','', ['class' => 'form-control','placeholder' => 'PullTest2', 'id' => 'toppulltest2', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest2') }}</small> </div>     
                        </div></br> 

                        <div class="row">
                            <div class="col-md-1"> {{Form::label('botsite3', 'Site 3:')}} </div>
                            <div class="col-md-3"> {{Form::text('toppulltest3','', ['class' => 'form-control','placeholder' => 'PullTest3', 'id' => 'toppulltest3', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest3') }}</small> </div>     
                        </div></br>
                    </div>  
                </div>
            </div>
                        <div class="card bottomBus">
                            <h5 class="card-header">Bottom</h5>
                                <div class="card-body">
                                <div class="jumbotron text-center">
                                <div class="row">
                                    <div class="col-md-1"> {{Form::label('bussite1', 'Site 1:')}} </div>
                                    <div class="col-md-3"> {{Form::text('buspulltest1','', ['class' => 'form-control','placeholder' => 'PullTest1', 'id' => 'buspulltest1', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest1') }}</small> </div> 
                                    <div class="col-md-1"> {{Form::label('botaverage', 'Average:')}} </div>
                                    <div class="col-md-3"> {{Form::text('busaverage','', ['class' => ' average form-control','placeholder' => 'Average', 'id' => 'busaverage', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botaverage') }}</small> </div>     
                                </div></br> 
                                
                                <div class="row">
                                    <div class="col-md-1"> {{Form::label('botsite2', 'Site 2:')}} </div>
                                    <div class="col-md-3"> {{Form::text('buspulltest2','', ['class' => 'form-control','placeholder' => 'PullTest2', 'id' => 'buspulltest2', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest2') }}</small> </div>     
                                </div></br> 
    
                                <div class="row">
                                    <div class="col-md-1"> {{Form::label('botsite3', 'Site 3:')}} </div>
                                    <div class="col-md-3"> {{Form::text('buspulltest3','', ['class' => 'form-control','placeholder' => 'PullTest3', 'id' => 'buspulltest3', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest3') }}</small> </div>     
                                </div></br>
                            </div>  
                        </div>
                    </div>

                    <div class="card bottom">
                        <h5 class="card-header">Bottom</h5>
                            <div class="card-body">
                            <div class="jumbotron text-center">
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('botsite1', 'Site 1:')}} </div>
                                <div class="col-md-3"> {{Form::text('botpulltest1','', ['class' => 'form-control','placeholder' => 'PullTest1', 'id' => 'botpulltest1', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest1') }}</small> </div> 
                                <div class="col-md-1"> {{Form::label('botaverage', 'Average:')}} </div>
                                <div class="col-md-3"> {{Form::text('botaverage','', ['class' => ' average form-control','placeholder' => 'Average', 'id' => 'botaverage', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botaverage') }}</small> </div>     
                            </div></br> 
                            
                            <div class="row">
                                <div class="col-md-1"> {{Form::label('botsite2', 'Site 2:')}} </div>
                                <div class="col-md-3"> {{Form::text('botpulltest2','', ['class' => 'form-control','placeholder' => 'PullTest2', 'id' => 'botpulltest2', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest2') }}</small> </div>     
                            </div></br> 

                            <div class="row">
                                <div class="col-md-1"> {{Form::label('botsite3', 'Site 3:')}} </div>
                                <div class="col-md-3"> {{Form::text('botpulltest3','', ['class' => 'form-control','placeholder' => 'PullTest3', 'id' => 'botpulltest3', 'onkeyup' => 'calc()'])}} <small class="form-text text-danger">{{ $errors->first('botpulltest3') }}</small> </div>     
                            </div></br>
                        </div>  
                    </div>
                </div>

                    
                    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                                {!! Form::close() !!}
 </div>


                                
                            @endsection
                            @push('jscript')
                                <script>
                                    function calc(){
                                    document.getElementById('average').value = ((
                                    parseFloat(document.getElementById('pulltest1').value) + 
                                    parseFloat(document.getElementById('pulltest2').value) + 
                                    parseFloat(document.getElementById('pulltest3').value)) / 3);

                                    document.getElementById('twoAverage').value = ((
                                    parseFloat(document.getElementById('twopulltest1').value) + 
                                    parseFloat(document.getElementById('twopulltest2').value) + 
                                    parseFloat(document.getElementById('twopulltest3').value)) / 3);

                                    document.getElementById('botaverage').value = ((
                                    parseFloat(document.getElementById('botpulltest1').value) + 
                                    parseFloat(document.getElementById('botpulltest2').value) + 
                                    parseFloat(document.getElementById('botpulltest3').value)) / 3);
                                    

                                    document.getElementById('topaverage').value = ((
                                    parseFloat(document.getElementById('toppulltest1').value) + 
                                    parseFloat(document.getElementById('toppulltest2').value) + 
                                    parseFloat(document.getElementById('toppulltest3').value)) / 3);
                                    
                                    
                                    document.getElementById('busaverage').value = ((
                                    parseFloat(document.getElementById('buspulltest1').value) + 
                                    parseFloat(document.getElementById('buspulltest2').value) + 
                                    parseFloat(document.getElementById('buspulltest3').value)) / 3);
                                    
                                    }


                                      $(document).ready(function () {
                                     if( $('.process').val() == 'Bussing1' || $('.process').val() == 'Bussing2')
                                     {$('.bottom').hide();
                                      $('.top1').show();
                                      $('.top2').show();
                                      $('.bottomBus').show();
                                      $('.top').hide();} 
                                      else  if( $('.process').val() == 'Rework' )
                                      { $('.bottom').show();
                                      $('.top1').hide();
                                      $('.top2').hide();
                                      $('.bottomBus').hide();
                                      $('.top').show();}
                                     
                                      else{
                                        $('.bottom').hide();
                                      $('.top1').hide();
                                      $('.top2').hide();
                                      $('.bottomBus').hide();
                                      $('.top').hide();
                                     
                                      }
                                    
                                     });

                                   $('.process').on('change', function (e) {
                                   //  $('select option').prop('disabled', true);
                                var optionSelected = $("option:selected", this);
                                var valueSelected = this.value;    
                               // alert(valueSelected);
                              //   $("select option:contains('" + valueSelected + "')").attr("disabled","disabled");

                              if(valueSelected == 'Bussing1' ||valueSelected == 'Bussing2')
                              {
                                      $('.bottom').hide();
                                      $('.top1').show();
                                      $('.top2').show();
                                      $('.top').hide();
                                      $('.bottomBus').show();
                              }else if(valueSelected == 'Rework' ){
                                      $('.bottom').show();
                                      $('.top1').hide();
                                      $('.top2').hide();
                                      $('.top').show();
                                      $('.bottomBus').hide();
                              }
                                });

                                     


                            </script>
                            @endpush

                            