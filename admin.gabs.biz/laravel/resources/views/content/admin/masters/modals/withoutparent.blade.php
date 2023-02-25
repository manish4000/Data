<div class="modal modal-slide-in new-data-modal fade" id="modals-slide-in">
    <div class="modal-dialog">
        <form class="add-data-modal modal-content pt-0" id="modelForm" name="modelForm">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
            </div>
            <div class="modal-body flex-grow-1">
                @if(isset($skippers) && !in_array('Name', $skippers))
                    <div class="form-group">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control dt-full-name" id="name" placeholder="Please Enter" name="name" aria-label="Asia" aria-describedby="basic-icon-default-fullname2" />
                    </div>
                @endif
                @if(!isset($skippers))
                    <div class="form-group">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control dt-full-name" id="name" placeholder="Please Enter" name="name" aria-label="Asia" aria-describedby="basic-icon-default-fullname2" />
                    </div> 
                @endif
                @if(isset($__master_data) && count($__master_data)>0)
                    @foreach($__master_data as $keyMD=>$valMD)                  
                    <div class="form-group">
                        <label class="form-label" for="{{$valMD['caption']}}">{{$valMD['caption']}}</label>
                        @if(isset($valMD['input_type']))
                            @if($valMD['input_type'] == 'text' && isset($valMD['input_group']) && $valMD['input_group'] == true)
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control pl-1 w-75" id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" value=""/>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light" id="basic-addon3">{{$valMD['input_group_caption']}}</span>
                                    </div>
                                </div>
                            @endif
                            @if(!isset($valMD['input_group']) && $valMD['input_type'] == 'text')
                                <input type="text" class="form-control" id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" placeholder="Please Enter" @if(isset($valMD['required'])){{'required="required"'}}@endif @if(isset($valMD['readonly'])){{'readonly="readonly"'}}@endif aria-label="" value="@if(isset($valMD['data'])){{$valMD['data']}}@endif" aria-describedby="basic-icon-default-fullname2" />
                            @endif
                            @if($valMD['input_type'] == 'checkbox')
                                <div class="custom-control custom-control-success custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}" value="Yes" />
                                    <label class="custom-control-label" for="{{$valMD['name_id']}}">Yes</label>
                                </div>
                            @endif
                            @if(!isset($valMD['input_group']) && $valMD['input_type'] == 'file')
                                <div class="media mt-2"> 
                                    @php $icon_file = asset('images/portrait/small/avatar-s-11.jpg'); @endphp
                                    <a href="javascript:void(0);" class="mr-25">
                                        <img src="{{$icon_file}}" id="upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                    </a>
                                    <!-- upload and reset button -->
                                    <div class="media-body mt-75 ml-1">
                                        <label for="img-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload Icon</label>
                                        <input type="file" name="icon_file" id="img-upload" hidden accept="image/*" />
                                        <input type="hidden" name="binary_file" id="binary_file" />
                                    </div>
                                    <!--/ upload and reset button -->
                                </div>
                            @endif
                        @else 
                        <select id="{{$valMD['name_id']}}" name="{{$valMD['name_id']}}@if(isset($valMD['multiple']) && $valMD['multiple']==true){{'[]'}}@endif" class="form-control @if(isset($valMD['class'])){{$valMD['class']}} @endif" @if(isset($valMD['multiple']) && $valMD['multiple']==true){{'multiple'}} @endif  @if(isset($valMD['onchange'])) onchange="{{$valMD['onchange']}}" @endif @if(isset($valMD['required']) && $valMD['required']==true) {{'required="required"'}} @endif>
                            <option value="">Select</option>                      
                            @if(isset($valMD['data']) && is_array($valMD['data']) && count($valMD['data'])>0)
                                @foreach($valMD['data'] as $__PD)
                                    @if(isset($__PD['id']))
                                        <option value="{{$__PD['id']}}" data-index="{{$__PD['id']}}">{{$__PD['name']}}</option>
                                    @endif
                                @endforeach
                            @elseif(isset($valMD['data'])) 
                                @foreach($valMD['data'] as $__PD)
                                    @if(isset($__PD->id))
                                        <option value="{{$__PD->id}}" data-index="{{$__PD->id}}">{{$__PD->name}}</option>
                                    @else 
                                        <option value="{{$__PD}}" data-index="{{$__PD}}">{{$__PD}}</option>
                                    @endif
                                @endforeach                      
                            @endif
                        </select>
                        @endif
                    </div>    
                    @endforeach
                @endif        
                @if(isset($skippers) && !in_array('Display', $skippers)) 
                    <div class="form-group">
                        <label class="form-label" for="parent_id">Display</label>
                        <div class="custom-control custom-control-success custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="display" id="display" value="Yes" checked />
                            <label class="custom-control-label" for="display">Yes</label>
                        </div>
                    </div>
                @endif
                @if(!isset($skippers))
                    <div class="form-group">
                        <label class="form-label" for="parent_id">Display</label>
                        <div class="custom-control custom-control-success custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="display" id="display" value="Yes" checked />
                            <label class="custom-control-label" for="display">Yes</label>
                        </div>
                    </div>                    
                @endif

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
                                    @foreach($valMD['data'] as $__PD)
                                        @if(isset($valMD['donot_set_id']))
                                            <option value="{{$__PD->name}}" data-index="{{$__PD->name}}">{{$__PD->name}}</option>
                                        @else
                                            <option value="{{$__PD->id}}" data-index="{{$__PD->id}}">{{$__PD->name}}</option>
                                        @endif                                
                                    @endforeach                      
                                @endif
                            @endif
                        </select>
                        @endif
                    </div>    
                    @endforeach
                @endif
                <input type="hidden" id="id" name="id" value=""/>
                <button type="submit" class="btn btn-primary mr-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

