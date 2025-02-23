    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label" for="basic-default-name">Name</label>
                {!! Form::text('name',Input::old('name'), ['class' => 'form-control','id'=>"name",'placeholder'=>'Enter Name']) !!} 
            </div>                                   
        </div>                                                                
    </div>     
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label" for="basic-default-name">Amount</label>
                {!! Form::text('amount',Input::old('amount'), ['class' => 'form-control','id'=>"amount",'placeholder'=>'Enter Amount']) !!} 
            </div>                                  
        </div> 
    </div>      
                
    <div class="row">
        <div class="col-12 d-flex flex-sm-row flex-column mt-2">
            @if(isset($data->id))
            <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1 submitbutton" name="submit" value="Submit">Update</button>&nbsp;
            @else
            <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1 submitbutton" name="submit" value="Submit">Save</button>&nbsp;
            @endif
            <a href="{{ url()->previous() }}"><button type="button" class="btn btn-outline-secondary">Cancel</button></a>
        </div>
    </div>    
</div>
                                                                                                   