{{-- <button class="btn btn-success nextBtn" wire:click="firstStepSubmit">Next</button>--}}
<button class="btn btn-success " type="button" wire:click="firstStepSubmit">{{trans('Parent_trans.Next')}}</button>
</div>
<div class="setup-content" style="display: {{ $currentStep == 2 ? 'block' : 'none' }}" id="step-2">
    <h3>{{trans('Parent_trans.Step2')}}</h3>
    <div class="col-xs-12">
        <div class="col-md-12">
            <br>

            <div class="form-row">
                <div class="col">
                    <label for="title">{{trans('Parent_trans.Name_Mother')}}</label>
                    <input type="text" wire:model="Name_Mother" class="form-control">
                    @error('Name_Mother')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="title">{{trans('Parent_trans.Name_Mother_en')}}</label>
                    <input type="text" wire:model="Name_Mother_en" class="form-control">
                    @error('Name_Mother_en')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3">
                    <label for="title">{{trans('Parent_trans.Job_Mother')}}</label>
                    <input type="text" wire:model="Job_Mother" class="form-control">
                    @error('Job_Mother')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="title">{{trans('Parent_trans.Job_Mother_en')}}</label>
                    <input type="text" wire:model="Job_Mother_en" class="form-control">
                    @error('Job_Mother_en')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col">
                    <label for="title">{{trans('Parent_trans.National_ID_Mother')}}</label>
                    <input type="text" wire:model="National_ID_Mother" class="form-control">
                    @error('National_ID_Mother')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="title">{{trans('Parent_trans.Passport_ID_Mother')}}</label>
                    <input type="text" wire:model="Passport_ID_Mother" class="form-control">
                    @error('Passport_ID_Mother')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col">
                    <label for="title">{{trans('Parent_trans.Phone_Mother')}}</label>
                    <input type="text" wire:model="Phone_Mother" class="form-control">
                    @error('Phone_Mother')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">{{trans('Parent_trans.Nationality_Father_id')}}</label>
                    <select class="custom-select my-1 mr-sm-2" wire:model="Nationality_Mother_id">
                        <option selected>{{trans('Parent_trans.Choose')}}...</option>
                        @foreach($Nationalities as $National)
                        <option value="{{$National->id}}">{{$National->Name}}</option>
                        @endforeach
                    </select>
                    @error('Nationality_Mother_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="inputState">{{trans('Parent_trans.Blood_Type_Father_id')}}</label>
                    <select class="custom-select my-1 mr-sm-2" wire:model="Blood_Type_Mother_id">
                        <option selected>{{trans('Parent_trans.Choose')}}...</option>
                        @foreach($Type_Bloods as $Type_Blood)
                        <option value="{{$Type_Blood->id}}">{{$Type_Blood->Name}}</option>
                        @endforeach
                    </select>
                    @error('Blood_Type_Mother_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="inputZip">{{trans('Parent_trans.Religion_Father_id')}}</label>
                    <select class="custom-select my-1 mr-sm-2" wire:model="Religion_Mother_id">
                        <option selected>{{trans('Parent_trans.Choose')}}...</option>
                        @foreach($Religions as $Religion)
                        <option value="{{$Religion->id}}">{{$Religion->Name}}</option>
                        @endforeach
                    </select>
                    @error('Religion_Mother_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">{{trans('Parent_trans.Address_Mother')}}</label>
                <textarea class="form-control" wire:model="Address_Mother" id="exampleFormControlTextarea1"
                    rows="4"></textarea>
                @error('Address_Mother')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


        </div>
    </div>
    <button class="btn btn-danger btn-sm nextBtn btn-lg pull-right" type="button" wire:click="back(1)">{{trans('Parent_trans.Back')}}</button>
    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="button" wire:click="secondStepSubmit">{{trans('Parent_trans.Next')}}</button>

    <!-- <button class="btn btn-success nextBtn" wire:click="secondStepSubmit">Next</button> -->
</div>

<div class="setup-content" style="display: {{ $currentStep == 3 ? 'block' : 'none' }};" id="step-3">
    <h3>{{trans('Parent_trans.save')}}</h3>
    <br>

<div class="row setup-content {{ $currentStep != 3 ? 'displayNone' : '' }}" id="step-3">
        @if ($currentStep != 3)
        <div style="display: none" class="row setup-content" id="step-3">
            @endif

            <div class="col-xs-12">
                <div class="col-md-12"><br>
                    <label style="color: red">{{trans('Parent_trans.Attachments')}}</label>
                    <div class="form-group">
                        <input type="file" wire:model="photos" accept="image/*" multiple>
                    </div>
                    <br>

                    <input type="hidden" wire:model="Parent_id">

                    <button class="btn btn-danger btn-sm nextBtn btn-lg pull-right" type="button"
                        wire:click="back(2)">{{ trans('Parent_trans.Back') }}</button>

                    @if($updateMode)
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" wire:click="submitForm_edit"
                        type="button">{{trans('Parent_trans.Finish')}}
                    </button>
                    @else
                    <button class="btn btn-success btn-sm btn-lg pull-right" wire:click="submitForm"
                        type="button">{{ trans('Parent_trans.Finish') }}</button>
                    @endif

                </div>
            </div>
        </div>

        </div>

    </div>