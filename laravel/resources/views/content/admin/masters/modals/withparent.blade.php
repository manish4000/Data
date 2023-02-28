<div class="modal modal-slide-in new-data-modal fade" id="modals-slide-in">
    <div class="modal-dialog">
        <form class="add-data-modal modal-content pt-0" id="modelForm" name="modelForm">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1"><h5 class="modal-title" id="exampleModalLabel">Add New</h5></div>
            <div class="modal-body flex-grow-1">
                @if(isset($__master_data) && count($__master_data)>0)
                    @foreach($__master_data as $keyMD=>$valMD)
                    <div class="form-group">
                        <label class="form-label" for="{{$valMD['caption']}}">{{$valMD['caption']}}</label>
                        @if(isset($valMD['input_type']))
                            @if($valMD['input_type'] == 'text')
                                <input type="text" class="form-control" id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" placeholder="Please Enter" aria-label="" aria-describedby="basic-icon-default-fullname2" />
                            @endif
                            @if($valMD['input_type'] == 'checkbox')
                                <div class="custom-control custom-control-success custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" value="Yes" />
                                    <label class="custom-control-label" for="{{$valMD['name_id']}}">Yes</label>
                                </div>
                            @endif
                            @if($valMD['input_type'] == 'textarea')
                                <textarea name="{{$valMD['name_id']}}" id="{{$valMD['name_id']}}" class="form-control" placeholder="Please Enter" cols="30" rows="10"></textarea>
                            @endif
                        @else
                        <select id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" class="form-control" @if(isset($valMD['onchange'])) onchange="{{$valMD['onchange']}}" @endif @if(isset($valMD['required']) && $valMD['required']==true) {{'required="required"'}} @endif>
                            <option value="">Select</option>                      
                            @if(isset($valMD['data'])) 
                                @if(is_array($valMD['data']) && count($valMD['data'])>0)
                                    @foreach($valMD['data'] as $__pKey => $__pVal)
                                        <option value="{{$__pKey}}" data-index="{{$__pKey}}">{{$__pVal}}</option>                              
                                    @endforeach                               
                                @else
                                    @if(isset($valMD['data']) && count($valMD['data'])>0)
                                        @foreach($valMD['data'] as $__PD)
                                            @if(isset($valMD['donot_set_id']))
                                                <option value="{{$__PD->name}}" data-index="{{$__PD->name}}">{{$__PD->name}}</option>
                                            @else
                                                <option value="{{$__PD->id}}" data-index="{{$__PD->id}}">{{$__PD->name}}</option>
                                            @endif                                
                                        @endforeach
                                    @endif                      
                                @endif
                            @endif
                        </select>
                        @endif
                    </div>    
                    @endforeach
                @endif

                @if(isset($__regionsData) && count($__regionsData)>0)
                <div class="form-group">
                    <label class="form-label" for="regions_id">Regions</label>
                    <select id="regions_id" name="regions_id" class="form-control">
                      <option value="">Select</option>                      
                          @foreach($__regionsData as $__PD)
                          <option value="{{$__PD->id}}" data-index="{{$__PD->id}}">{{$__PD->name}}</option>
                          @endforeach                      
                    </select>
                </div>
                @endif

                @if(isset($__countriesData) && count($__countriesData)>0)
                <div class="form-group">
                    <label class="form-label" for="countries_id">Country</label>
                    <select id="countries_id" name="countries_id" class="form-control">
                      <option value="">Select</option>                      
                          @foreach($__countriesData as $__PD)
                          <option value="{{$__PD->id}}" data-index="{{$__PD->id}}">{{$__PD->name}}</option>
                          @endforeach                      
                    </select>
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control dt-full-name" id="name" placeholder="Please Enter" name="name" aria-label="Asia" aria-describedby="basic-icon-default-fullname2" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="parent_id">Parent Value</label>
                    <select id="parent_id" name="parent_id" class="form-control">
                        <option value="">Select</option>
                    @if(isset($__parentData) && count($__parentData)>0)
                        @foreach($__parentData as $__PD)
                        <option value="{{$__PD->id}}" data-index="{{$__PD->id}}">{{$__PD->name}}</option>
                        @endforeach
                    @endif
                    </select>
                </div>

                @if(isset($__master_data_bot) && count($__master_data_bot)>0)
                    @foreach($__master_data_bot as $keyMD=>$valMD)
                    <div class="form-group">
                        <label class="form-label" for="{{$valMD['caption']}}">{{$valMD['caption']}}</label>
                        @if(isset($valMD['input_type']))
                            @if($valMD['input_type'] == 'text')
                                <input type="text" class="form-control" id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" placeholder="Please Enter" aria-label="" aria-describedby="basic-icon-default-fullname2" />
                            @endif
                            @if($valMD['input_type'] == 'checkbox')
                                <div class="custom-control custom-control-success custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" value="Yes" />
                                    <label class="custom-control-label" for="{{$valMD['name_id']}}">Yes</label>
                                </div>
                            @endif
                            @if($valMD['input_type'] == 'textarea')
                                <textarea name="{{$valMD['name_id']}}" id="{{$valMD['name_id']}}" class="form-control" placeholder="Please Enter" cols="30" rows="10"></textarea>
                            @endif
                        @else 
                        <select id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" class="form-control" @if(isset($valMD['onchange'])) onchange="{{$valMD['onchange']}}" @endif @if(isset($valMD['required']) && $valMD['required']==true) {{'required="required"'}} @endif>
                            <option value="">Select</option>                      
                            @if(isset($valMD['data'])) 
                                @if(is_array($valMD['data']) && count($valMD['data'])>0)
                                    @foreach($valMD['data'] as $__pKey => $__pVal)
                                        <option value="{{$__pKey}}" data-index="{{$__pKey}}">{{$__pVal}}</option>                              
                                    @endforeach                               
                                @else
                                    @if(isset($valMD['data']) && count($valMD['data'])>0)
                                        @foreach($valMD['data'] as $__PD)
                                            @if(isset($valMD['donot_set_id']))
                                                <option value="{{$__PD->name}}" data-index="{{$__PD->name}}">{{$__PD->name}}</option>
                                            @else
                                                <option value="{{$__PD->id}}" data-index="{{$__PD->id}}">{{$__PD->name}}</option>
                                            @endif                                
                                        @endforeach
                                    @endif                      
                                @endif
                            @endif
                        </select>
                        @endif
                    </div>    
                    @endforeach
                @endif

                <div class="form-group">
                    <label class="form-label" for="parent_id">Display</label>
                    <div class="custom-control custom-control-success custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="display" id="display" value="Yes" checked />
                        <label class="custom-control-label" for="display">Yes</label>
                    </div>
                </div>
                <input type="hidden" id="id" name="id" value=""/>
                <button type="submit" class="btn btn-primary mr-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>