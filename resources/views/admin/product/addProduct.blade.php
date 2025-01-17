<!DOCTYPE html>
<html lang="en">
<head>

    @include('admin.link')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    @if(!empty(session()->get('productDataLabels')))
    <style>
      #productPricingForm{
        display: block;
      } 
      #productInfoForm, #productPropertyForm{
        display: none;
      } 
      
      </style>
      @elseIf(session('productKey') !== null)
      <style>
        #productPropertyForm{
          display: block;
        } 
        #productInfoForm, #productPricingForm{
          display: none;
        } 
        
        </style>
      @else
      <style>
        #productPricingForm, #productPropertyForm{
          display: none;
        } 
      </style> 
      @endif

</head>
<body class="hold-transition sidebar-mini over">
<div class="wrapper">

    @include('admin.section.navbar')
    
  @include('admin.section.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">New Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Add Product</li>
            </ol>
          </div><!-- /.col -->
          <div>
            
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>  
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container mb-5">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card p-3 shadow">
                @if (session('message'))
                <div class="alert alert-success success-msg">
                    {{ session('message') }}
                </div>
                @endif
                @if (count($errors) > 0)
		            	<div class="alert alert-success imgerror">
		            		<ul>
		            			@foreach ($errors->all() as $error)
		            				<li>{{ $error }}</li>
		            			@endforeach
		            		</ul>
		            	</div>
		            @endif
                <form id="productInfoForm">
                  <div class="alert alert-primary shadow text-center"><h5 class="font-weight-bold">Basic Product Information</h5></div>
                  <div class="form-row mb-2">
                    <input type="hidden" name="productArrayKey" value="{{$productArrayKey ?? 'none'}}">
                    <div class="col-md-6">  
                      @if (session('showProductData') !== null)
                      <label for="">Category</label>
                      <input type="hidden" value="{{$category->id ?? ''}}" name="category_id">
                      <input type="text" class="form-control" readonly disabled value="{{str_replace('-',' ',$category->name ??'')}}" name="cat_name">
                      @else 
                      <label for="">Select Category</label>
                      <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{isset($productData) && $productData !== null ? $productData->catId ?? $productData->category_id == $category->id ? 'selected' : '' : ''}}>{{str_replace('-',' ',$category->name)}}</option>
                        @endforeach
                      </select>
                      @endif
                    </div>
                    <div class="col-md-6">
                      <label for="">Product Name</label>
                      <input type="text" class="form-control text-capitalize" name="productName" placeholder="Enter Product Name" required value="{{str_replace('-',' ',$productData['name'][$productArrayKey] ?? '')}}">
                    </div>
                  </div>
                      <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control text-capitalize" id="textEditor" name="productDesc" placeholder="Enter product description" rows="3">{{$productData['desc'][$productArrayKey] ?? ''}}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="">Product Specifications</label>
                        <div class="form-row specs">
                          @if($productData !== null)
                          @foreach($productData['specification'][$productArrayKey] as $specs)
                          <div class="col-md-6">
                            <div class="form-group">
                              <input type="text" name="specs[]" placeholder="Product Specification" class="form-control" value="{{$specs}}">
                            </div>
                          </div>
                          @endforeach
                          @else
                          <div class="col-md-6">
                            <div class="form-group">
                              <input type="text" name="specs[]" placeholder="Product Specification" class="form-control" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <input type="text" name="specs[]" placeholder="Product Specification" class="form-control" >
                            </div>
                          </div>
                          @endif
                          
                        </div>
                        <div class="btn-inline mt-2 text-center">
                          <button class="btn btn-outline-danger btn-sm" type="button" id="removeSpec"><i class="fa fa-minus"></i> Remove</button>
                          <button class="btn btn-outline-success btn-sm ml-auto" type="button" id="addSpec"><i class="fa fa-plus"></i> Add</button>
                        </div>
                      </div>
                      <div class="alert alert-danger shadow text-center"><h5 class="font-weight-bold">Product Features (necessary)</h5></div>
                      <div class="form-row">

                      <div class="col-md-3 col-lg-3 form-group sizeDiv">
                        <label for="">Product Size :</label>
                        <div class="sizes">
                          @if($productData !== null && isset($productData['size'][$productArrayKey]))
                          @foreach($productData['size'][$productArrayKey] as $size)
                            <div class="form-group">
                              <input type="text" name="size[]" placeholder='Example : 2 x 3.5... ' class="form-control" value="{{$size}}">
                            </div>
                          @endforeach
                          @else
                          <div class="form-group">
                            <input type="text" name="size[]" placeholder='Example : 2 x 3.5... ' class="form-control" >
                          </div>
                          @endif
                        </div>
                        <div class="btn-inline mt-2 text-center">
                          <button class="btn btn-outline-danger btn-sm" type="button" id="removeSize"><i class="fa fa-minus"></i> Remove</button>
                          <button class="btn btn-outline-success btn-sm ml-auto" type="button" id="addSize"><i class="fa fa-plus"></i> Add</button>
                        </div>
                      </div>
                      <div class="col-md-3 col-lg-3 form-group paperTypeDiv" style="border-left:0.2px solid grey">
                        <label for="">Paper Type :</label>
                        <div class="paperType">
                          @if($productData !== null && $productData['paper_type'][0] !== null)
                          @foreach($productData['paper_type'][$productArrayKey] as $paperType)
                            <div class="form-group">
                              <input type="text" name="paperType[]" placeholder='Example : 14pt stock matt ' class="form-control" value="{{$paperType}}">
                            </div>
                          @endforeach
                          @else
                          <div class="form-group">
                            <input type="text" name="paperType[]" placeholder='Example : 14pt stock matt ' class="form-control" >
                          </div>
                          @endif
                        </div>
                        <div class="btn-inline mt-2 text-center">
                          <button class="btn btn-outline-danger btn-sm" type="button" id="removePaperType"><i class="fa fa-minus"></i> Remove</button>
                          <button class="btn btn-outline-success btn-sm ml-auto" type="button" id="addPaperType"><i class="fa fa-plus"></i> Add</button>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6 form-group qtyDiv" style="border-left:0.2px solid grey">
                        <label for="">Quantity :</label>
                          <div class="form-row qty">
                            @if($productData !== null && isset($productData['qty'][$productArrayKey]))
                          @foreach($productData['qty'][$productArrayKey] as $qty)
                            <div class="col-md-3">
                              <div class="form-group">
                                <input type="text" name="qty[]" placeholder="Qty" class="form-control" value="{{$qty}}">
                              </div>
                            </div>
                            @endforeach
                          @else
                            <div class="col-md-3">
                              <div class="form-group">
                                <input type="text" name="qty[]" placeholder="Qty" class="form-control">
                              </div>
                            </div> 
                            @endif
                          </div>
                        <div class="btn-inline mt-2 text-center">
                          <button class="btn btn-outline-danger btn-sm" type="button" id="removeQty"><i class="fa fa-minus"></i> Remove</button>
                          <button class="btn btn-outline-success btn-sm ml-auto" type="button" id="addQty"><i class="fa fa-plus"></i> Add</button>
                        </div>
                      </div>

                    </div>
                    <hr>
                    <div class="form-group text-center">
                      <button type="button" class="btn btn-primary shadow" id="productInfoNext">Next <i class="fa fa-arrow-right"></i></button>
                    </div>
                </form>
                @if(session('productKey') !== null)
                  <form id="productPropertyForm">

                    <div class="alert alert-warning shadow text-center"><h5 class="font-weight-bold">Product Properties (if any)</h5></div>
                    <input type="hidden" name="category_id" value="{{isset($productData) && $productData !== null ? $productData->catId ?? $productData->category_id : $category->id}}">
                    <input type="hidden" name="label_session" value="{{session('productDataLabels')['category_id'] ?? ''}}">
                    <input type="hidden" name="productArrayKey" value="{{session()->get('productKey') !== null ? session()->get('productKey') : ($productArrayKey ?? 'none')}}">
                    <div class="col-md-12">
                     <div class="form-row" id="properties">
                      @if(isset($productData['property'][$productArrayKey]))
                      @foreach($productData['property'][$productArrayKey] as $key=>$property)
                       <div class="col-md-3">
                         <div class="card shadow">
                         <div class="card-body">
 
                         <div class="form-group">
                           <label for="">Property Label :</label>
                          
                             <div class="form-group">
                               <input class="form-control" type="text" name="labels[]" value="{{str_replace('-',' ',$property ?? '')}}">
                             </div>
                             
                           
                         </div>
 
                         <div class="form-group propertyData{{$key}}">
                          @if(isset($productData['property_data'][$productArrayKey][$key]))
                          @foreach($productData['property_data'][$productArrayKey][$key] as $pKey=>$data)
                           <div class="rounded border p-2 mb-2">
                             <label for="">Property Data :</label>
                             <div class="form-group">
                               <input class="form-control data{{$key}}" type="text" name="data{{$key}}[]" value="{{$data ?? ''}}">
                             </div>
                             <div class="form-row">
                              <div class="col-md-8">
                                <label for="">Action :</label>
                                <select name="action{{$key}}[]" class="form-control">
                                  <option @if(isset($productData['property_action'][$productArrayKey][$key][$pKey]) && $productData['property_action'][$productArrayKey][$key][$pKey] == 1){{$productData['property_action'][$productArrayKey][$key][$pKey] == 1 ? 'selected' : ''}}@endif value="1">Percentage</option>
                                  <option @if(isset($productData['property_action'][$productArrayKey][$key][$pKey]) && $productData['property_action'][$productArrayKey][$key][$pKey] == 0){{$productData['property_action'][$productArrayKey][$key][$pKey] == 0 ? 'selected' : ''}}@endif value="0">Fix Value</option>
                                </select>
                              </div>
                              <div class="col-md-4">
                                <label for="">Value :</label>
                                <input type="text" class="form-control percentage{{$key}}" value="{{$productData['property_percentage'][$productArrayKey][$key][$pKey] ?? ''}}" name="percentage{{$key}}[]">
                              </div>
                            </div>
                           </div>
                           @endforeach
                           @else 
                           <div class="rounded border p-2 mb-2">
                            <label for="">Property Data :</label>
                            <div class="form-group">
                              <input class="form-control data{{$key}}" type="text" name="data{{$key}}[]" placeholder="Enter Data">
                            </div>
                            <div class="form-row">
                              <div class="col-md-8">
                                <label for="">Action :</label>
                                <select name="action{{$key}}[]" class="form-control">
                                  <option value="1">Percentage</option>
                                  <option value="0">Fix Value</option>
                                </select>
                              </div>
                              <div class="col-md-4">
                                <label for="">Value :</label>
                                <input type="text" class="form-control percentage{{$key}}" name="percentage{{$key}}[]">
                              </div>
                              </div>
                          </div>
                           @endif
                         </div>
                         
                       
                         <div class="btn-inline mt-2">
                           <button class="btn btn-outline-danger btn-sm removePData{{$key}}" type="button" data-key="{{$key}}" onclick="remove({{$key}})"><i class="fa fa-minus"></i></button>
                           <button class="btn btn-outline-primary btn-sm float-right addPData{{$key}}" type="button" data-key="{{$key}}" onclick="plus({{$key}})"><i class="fa fa-plus"></i></button>
                        </div>
                           </div>
                         </div>
                       </div>
                       @endforeach
                       @else 
                       <div class="col-md-3">
                        <div class="card shadow">
                          <div class="card-body">
                            <div class="form-group">
                              <label for="">Property Label :</label>
                              <div class="form-group">
                                <input name="labels[]" class="form-control" placeholder="Name" type="text">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                       @endif
                   </div>
                 </div>
                 <hr>
                 <div class="col-md-12">
                   <div class="btn-inline mt-2">
                     <button class="btn btn-outline-danger btn-sm" type="button" id="removeProperty"><i class="fa fa-minus"></i> Remove</button>
                     <button class="btn btn-outline-primary btn-sm float-right" type="button" id="addProperty"><i class="fa fa-plus"></i> Add</button>
                   </div>
                 </div>
                 <hr>
                 <div class="form-group text-center">
                  <button type="button" class="btn btn-dark shadow" id="productPropertyBack"><i class="fa fa-arrow-left"></i> Back</button>
                  <button type="button" class="btn btn-primary shadow" id="productPropertyNext">Next <i class="fa fa-arrow-right"></i></button>
                </div>
              </form>
              @endif
                    @if(!empty(session()->get('productDataLabels')))
                    <form id="productPricingForm">
                    <div class="form-row">
                        <div class="col-md-12 text-center">
                          <div class="alert alert-success shadow text-center"><h5 class="font-weight-bold">Add Product Price</h5></div>
                        </div>
                        <input type="hidden" name="productArrayKey" value="{{$productArrayKey ?? 'none'}}">
                        <input type="hidden" name="category_id" value="{{isset($productData) && $productData !== null ? $productData->catId ?? $productData->category_id : $category->id}}">
                        <div class="col-md-12">
                          @if ($productData !== null && isset($productData['pricing'][$productArrayKey]) && $productData->category_id != 1 && $productData->category_id != 10)
                              
                          @foreach ($productData['pricing'][$productArrayKey] as $key=>$pricing)
                          <div class="form-row align-items-center">
                            @if(isset($productData) && $productData['size'][0] !== null)
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Size :</label>
                                <select name="pricingSize[]" class="form-control">
                                @if($productData !== null && isset($productData['size'][$productArrayKey]))
                                @foreach($productData['size'][$productArrayKey] as $size)
                                <option {{$pricing[0] == $size ? 'selected' : ''}} value="{{$size}}">{{$size}}</option>
                                @endforeach
                                @else 
                                <option value="">No size added</option>
                                @endif
                              </select>
                            </div>
                          </div>
                          @endif
                          @if(isset($productData) && $productData['paper_type'][0] !== null)
                          <div class="col-md-3 paperTypeDiv">
                            
                            <div class="form-group">
                              <label for="">Paper Type :</label>
                              <select name="pricingPaperType[]" class="form-control">
                                @if($productData !== null && isset($productData['paper_type'][$productArrayKey]))
                                @foreach($productData['paper_type'][$productArrayKey] as $paperType)
                                <option {{$pricing[1] == $paperType ? 'selected' : ''}} value="{{$paperType}}">{{$paperType}}</option>
                                @endforeach
                                @else 
                                <option value="">No size added</option>
                                @endif
                              </select>
                            </div>
                          </div>
                          @endif
                          @if($productData !== null && $productData->category_id == 3 || $productData->category_id == 4 || $productData->category_id == 5 || $productData->category_id == 6 || $productData->category_id == 7 || $productData->category_id == 8 || $productData->category_id == 9)
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Quantity :</label>
                              <select name="pricingQty[]" class="form-control">
                                @if($productData !== null && isset($productData['qty'][$productArrayKey]))
                                @foreach($productData['qty'][$productArrayKey] as $qty)
                                <option {{$pricing[2] == $qty ? 'selected' : ''}} value="{{$qty}}">{{$qty}}</option>
                                @endforeach
                                @else 
                                <option value="">No size added</option>
                                @endif
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Amount :</label>
                              <input type="text" class="form-control" placeholder="Enter Amount" name="pricing[]" value="{{$pricing[3]}}">
                            </div>
                          </div>
                          @endif
                          @if($productData !== null && $productData->category_id == 2)
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Quantity :</label>
                              <select name="pricingQty[]" class="form-control">
                                @if($productData !== null && isset($productData['qty'][$productArrayKey]))
                                @foreach($productData['qty'][$productArrayKey] as $qty)
                                <option {{$pricing[1] == $qty ? 'selected' : ''}} value="{{$qty}}">{{$qty}}</option>
                                @endforeach
                                @else 
                                <option value="">No size added</option>
                                @endif
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Stand Amount :</label>
                              <input type="text" class="form-control" placeholder="Enter Amount" name="pricing[]" value="{{$pricing[2]}}">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Banner Amount :</label>
                              <input type="text" class="form-control" placeholder="Enter Amount" name="banner_pricing[]" value="{{$pricing[3] ?? 0}}">
                            </div>
                          </div>
                          @endif
                        </div>
                        @endforeach
                        @endif
                      </div>
                  
                      @if($productData !== null && $productData->category_id != 1 && $productData->category_id != 10 && $productData->category_id != 11)
                      <div class="col-md-12" id="qtyPricing">
                          <div class="form-row align-items-center">
                            @if(isset($productData) && $productData['size'][0] !== null)
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Size :</label>
                                <select name="pricingSize[]" class="form-control">
                                  @if($productData !== null && isset($productData['size'][$productArrayKey]))
                                  @foreach($productData['size'][$productArrayKey] as $size)
                                  <option value="{{$size}}">{{$size}}</option>
                                  @endforeach
                                  @else 
                                  <option value="">No size added</option>
                                  @endif
                                </select>
                              </div>
                            </div>
                            @endif
                            @if(isset($productData) && $productData['paper_type'][0] !== null)
                            <div class="col-md-3 paperTypeDiv">

                              <div class="form-group">
                                <label for="">Paper Type :</label>
                                <select name="pricingPaperType[]" class="form-control">
                                  @if($productData !== null && isset($productData['paper_type'][$productArrayKey]))
                                  @foreach($productData['paper_type'][$productArrayKey] as $paperType)
                                  <option value="{{$paperType}}">{{$paperType}}</option>
                                  @endforeach
                                  @else 
                                  <option value="">No size added</option>
                                  @endif
                                </select>
                              </div>
                            </div>
                            @endif
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Quantity :</label>
                                <select name="pricingQty[]" class="form-control">
                                  @if($productData !== null && isset($productData['qty'][$productArrayKey]))
                                @foreach($productData['qty'][$productArrayKey] as $qty)
                                  <option value="{{$qty}}">{{$qty}}</option>
                                @endforeach
                                @else 
                                  <option value="">No size added</option>
                                  @endif
                                </select>
                              </div>
                            </div>
                            @if($productData !== null && $productData->category_id == 2)
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Stand Amount :</label>
                                <input type="text" class="form-control" placeholder="Enter Amount" name="pricing[]">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Banner Amount :</label>
                                <input type="text" class="form-control" placeholder="Enter Amount" name="banner_pricing[]" value="0">
                              </div>
                            </div>
                            @else
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="">Amount :</label>
                                <input type="text" class="form-control" placeholder="Enter Amount" name="pricing[]">
                              </div>
                            </div>
                            
                            @endif
                        </div>
                      </div>
                      
                      <div class="col-md-12" id="pricingClone">

                      </div>
                      <div class="col-md-12">
                        <div class="btn-inline mt-2">
                          <button class="btn btn-outline-danger btn-sm" type="button" id="removeQtypricing"><i class="fa fa-minus"></i> Remove</button>
                          <button class="btn btn-outline-primary btn-sm float-right" type="button" id="addQtypricing"><i class="fa fa-plus"></i> Add</button>
                        </div>
                      </div>
                      <div class="col-md-12" id="qtyPricing">
                        @elseIf($productData !== null && $productData->category_id == 10)
                        <div class="col-md-12" id="cat10">
                          @if($productData !== null && isset($productData['pricing'][$productArrayKey]))
                          @foreach ($productData['pricing'][$productArrayKey] as $key=>$pricing)
                          <div class="col-md-12">
                            <div class="form-row align-items-center">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Size(Sq ft) :</label>
                                  <input name="pricingSize[]" class="form-control" placeholder="Ex : 1-60" type="text" value="{{isset($productData) && isset($productData['pricing'][$productArrayKey]) ? $pricing[0] : ''}}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Amount :</label>
                                  <input type="text" class="form-control" placeholder="Enter Amount" value="{{isset($productData) && isset($productData['pricing'][$productArrayKey]) ? $pricing[1] : ''}}" name="pricing[]">
                                </div>
                              </div>
                            </div>
                          </div>
                          @endforeach
                          @else 
                          <div class="col-md-12">
                            <div class="form-row align-items-center">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Size(Sq ft) :</label>
                                  <input name="pricingSize[]" class="form-control" placeholder="Ex : 1-60" type="text">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Amount :</label>
                                  <input type="text" class="form-control" placeholder="Enter Amount" name="pricing[]">
                                </div>
                              </div>
                            </div>
                          </div>
                          @endif
                        </div>
                          <div class="col-md-12" id="pricingClone10">

                            </div>
                            <div class="col-md-12">
                              <div class="btn-inline mt-2">
                                <button class="btn btn-outline-danger btn-sm" type="button" id="removeQtypricing10"><i class="fa fa-minus"></i> Remove</button>
                                <button class="btn btn-outline-primary btn-sm float-right" type="button" id="addQtypricing10"><i class="fa fa-plus"></i> Add</button>
                              </div>
                            </div>
                        @elseIf($productData !== null && $productData->category_id == 11)
                        <div class="col-md-12" id="cat11">
                          @if($productData !== null && isset($productData['pricing'][$productArrayKey]))
                          @foreach ($productData['pricing'][$productArrayKey] as $key=>$pricing)
                          <div class="col-md-12">
                            <div class="form-row align-items-center">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Quantity :</label>
                                  <input name="pricingQty[]" class="form-control" type="text" value="{{isset($productData) && isset($productData['pricing'][$productArrayKey]) ? $pricing[0] : '1'}}">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Amount :</label>
                                  <input type="text" class="form-control" placeholder="Enter Amount" value="{{isset($productData) && isset($productData['pricing'][$productArrayKey]) ? $pricing[1] : ''}}" name="pricing[]">
                                </div>
                              </div>
                            </div>
                          </div>
                          @endforeach
                          @else 
                          <div class="col-md-12">
                            <div class="form-row align-items-center">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Quantity :</label>
                                  <input name="pricingQty[]" class="form-control" value="1" type="text">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="">Amount :</label>
                                  <input type="text" class="form-control" placeholder="Enter Amount" name="pricing[]">
                                </div>
                              </div>
                            </div>
                          </div>
                          @endif
                        </div>
                          <div class="col-md-12" id="pricingClone11">

                            </div>
                            <div class="col-md-12">
                              <div class="btn-inline mt-2">
                                <button class="btn btn-outline-danger btn-sm" type="button" id="removeQtypricing11"><i class="fa fa-minus"></i> Remove</button>
                                <button class="btn btn-outline-primary btn-sm float-right" type="button" id="addQtypricing11"><i class="fa fa-plus"></i> Add</button>
                              </div>
                            </div>
                      @else
                      <div class="col-md-12">
                        <div class="form-row align-items-center">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Size(feet) :</label>
                                <input name="pricingSize[]" class="form-control" value="0-99" type="hidden">
                                <input type="text" value="Up to 99 sqft" class="form-control" disabled readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Amount :</label>
                              <input type="text" class="form-control" placeholder="Enter Amount" value="{{isset($productData) && isset($productData['pricing'][$productArrayKey]) ? $productData['pricing'][$productArrayKey][0][1] : ''}}" name="pricing[]">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-row align-items-center">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Size(feet) :</label>
                                <input name="pricingSize[]" class="form-control" value="100-149" type="hidden">
                                <input type="text" value="100 to 149 sqft" class="form-control" disabled readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Amount :</label>
                              <input type="text" class="form-control" placeholder="Enter Amount" value="{{isset($productData) && isset($productData['pricing'][$productArrayKey]) ? $productData['pricing'][$productArrayKey][1][1] : ''}}" name="pricing[]">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-row align-items-center">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Size(feet) :</label>
                                <input name="pricingSize[]" class="form-control" value="150-199" type="hidden">
                                <input type="text" value="150 to 199 sqft" class="form-control" disabled readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Amount :</label>
                              <input type="text" class="form-control" placeholder="Enter Amount" value="{{isset($productData) && isset($productData['pricing'][$productArrayKey]) ? $productData['pricing'][$productArrayKey][2][1] : ''}}" name="pricing[]">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-row align-items-center">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Size(feet) :</label>
                                <input name="pricingSize[]" class="form-control" value="200" type="hidden">
                                <input type="text" value="200 sqft and above" class="form-control" disabled readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="">Amount :</label>
                              <input type="text" class="form-control" placeholder="Enter Amount" value="{{isset($productData) && isset($productData['pricing'][$productArrayKey]) ? $productData['pricing'][$productArrayKey][3][1] : ''}}" name="pricing[]">
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif

                      </div> 
                      <hr>
                      
                      <div class="form-group text-center">
                        <button class="btn btn-dark shadow" type="button" id="productPricingBack"><i class="fa fa-arrow-left"></i> Back</button>
                        <button class="btn btn-primary shadow" type="button" id="productPricingFinish">Finish <i class="fa fa-check"></i></button>
                      </div> 
                    </form>
                    @endif
              </div>
            </div>

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
  @include('admin.section.footer')
{{-- @endif --}}
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('admin.script')
/* <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> */
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#textEditor').summernote({
            placeholder: 'Enter Product Description',
            tabsize: 1,
            height: 120,
            toolbar: [
              ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
              ['insert', ['link']],
              ['view', ['help']]
            ]
        });
        
    });
  </script>
<script>
    $('select[name="category_id"]').click(function(){
      var catName = $(this).val();
      /* alert(catName); */
      if(catName == 1 || catName == 10)
      {
        $('.sizeDiv').slideDown();
        $('.paperTypeDiv').slideUp();
        $('.qtyDiv').slideUp();
      }
      if(catName == 2)
      {
        $('.sizeDiv').slideDown();
        $('.qtyDiv').slideDown();
        $('.paperTypeDiv').slideUp();
      }
      if(catName == 11)
      {
        $('.sizeDiv').slideUp();
        $('.paperTypeDiv').slideUp();
        $('input[name="qty[]"]').val(1);
        $('.qtyDiv').slideDown();
      }
      if(catName == 3 || catName == 4 || catName == 5 || catName == 6 || catName == 7 || catName == 8 || catName == 9)
      {
        $('.sizeDiv').slideDown();
        $('.paperTypeDiv').slideDown();
        $('.qtyDiv').slideDown();
      }
    });
    $('#addSpec').click(function(){
        $('.specs').append('<div class="col-md-6"><div class="form-group"><input type="text" name="specs[]" placeholder="Product Specification" class="form-control"></div></div>');
    });
    $('#removeSpec').click(function() {
        $('.specs').children().last().remove();
    });
    $('#addSize').click(function(){
        $('.sizes').append('<div class="form-group"><input type="text" name="size[]" placeholder="Example : as previous mentioned" class="form-control"></div>');
    });
    $('#removeSize').click(function() {
      var count = $(".sizes").find("*").length;
      if(count > 2)
      {
        $('.sizes').children().last().remove();
      }
    });
    $('#addPaperType').click(function(){
        $('.paperType').append('<div class="form-group"><input type="text" name="paperType[]" placeholder="Example : as previous mentioned" class="form-control"></div>');
    });
    $('#removePaperType').click(function() {
      var count = $(".paperType").find("*").length;
      if(count > 2)
      {
        $('.paperType').children().last().remove();
      }
    });
    $('#addQty').click(function(){
        $('.qty').append('<div class="col-md-3"><div class="form-group"><input type="text" name="qty[]" placeholder="Qty" class="form-control" ></div></div>');
    });
    $('#removeQty').click(function() {
      var count = $(".qty").find("*").length;
      if(count > 3)
      {
        $('.qty').children().last().remove();
      }
    });
    $('#addQtypricing').click(function(){
      var clone = $('#qtyPricing .form-row').clone();
      $('#pricingClone').append(clone);
    });
    $('#removeQtypricing').click(function() {
      var count = $("#pricingClone").find("*").length;
      $('#pricingClone').children().last().remove();
    });
    $('#addQtypricing10').click(function(){
      var clone = $('#cat10').children().last().clone();
      $('#pricingClone10').append(clone);
    });
    $('#removeQtypricing10').click(function() {
      var count = $("#pricingClone10").find("*").length;
      var count2 = $("#cat10").find("*").length;
      if(count > 0)
      {
        $('#pricingClone10').children().last().remove();
      } else {
        if(count2 > 10)
        {
          $('#cat10').children().last().remove();
        }
      }
    });
    $('#addQtypricing11').click(function(){
      var clone = $('#cat11').children().last().clone();
      $('#pricingClone11').append(clone);
    });
    $('#removeQtypricing11').click(function() {
      var count = $("#pricingClone11").find("*").length;
      var count2 = $("#cat11").find("*").length;
      if(count > 0)
      {
        $('#pricingClone11').children().last().remove();
      } else {
        if(count2 > 10)
        {
          $('#cat11').children().last().remove();
        }
      }
    });


    $('#addProperty').click(function(){
        $('#properties').append('<div class="col-md-3"><div class="card shadow"><div class="card-body"><div class="form-group"><label for="">Property Label :</label><div class="form-group"><input name="labels[]" class="form-control" placeholder="Name" type="text"></div></div></div></div></div>');
    });
    $('#removeProperty').click(function() {
      var count = $("#properties").find("*").length;
      if(count > 7)
      {
        $('#properties').children().last().remove();
      }
    });
</script>
<script>
  function plus(key){
      var key = key;
      // alert(key);
    $('.propertyData'+key).append('<div class="rounded border p-2 mb-2"><label for="">Property Data :</label><div class="form-group"><input class="form-control data'+key+'" type="text" name="data'+key+'[]" placeholder="Enter Data"></div><div class="form-row"><div class="col-md-8"><label for="">Action :</label><select name="action'+key+'[]" class="form-control"><option value="1">Percentage</option><option value="0">Fix Value</option></select></div><div class="col-md-4"><label for="">Value :</label><input type="text" class="form-control percentage'+key+'" name="percentage'+key+'[]"></div></div></div>')
  };
  function remove(key){
    var key = key;
    var count = $(".propertyData"+key).find("*").length;
    if(count > 13)
    {
      $('.propertyData'+key).children().last().remove();
    }
  };
</script>
<script>
  $(document).ready(function() {
    var catName = $('select[name="category_id"]').val();
    var catName2 =  $('input[name="category_id"]').val();
    var finalCatName = catName || catName2;
    // alert(finalCatN  ame);
    if(finalCatName == 1 || finalCatName == 10)
      {
        $('.sizeDiv').show();
        $('.paperTypeDiv').hide();
        $('.qtyDiv').hide();
      }
      if(finalCatName == 2)
      {
        $('.sizeDiv').show();
        $('.paperTypeDiv').hide();
        $('.qtyDiv').slideDown();
      }
      if(finalCatName == 11)
      {
        $('.sizeDiv').hide();
        $('.paperTypeDiv').hide();
        $('.qtyDiv').slideDown();
      }
      if(finalCatName == 3 || finalCatName == 4 || finalCatName == 5 || finalCatName == 6 || finalCatName == 7 || finalCatName == 8 || finalCatName == 9)
      {
        $('.sizeDiv').slideDown();
        $('.paperTypeDiv').slideDown();
        $('.qtyDiv').slideDown();
      }
    $('#productInfoNext').on('click', function(e){
      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
      e.preventDefault();
      var catId = $('select[name="category_id"]').val() ?? $('input[name="category_id"]').val();
      var catName = $('select[name="category_id"]').find(':selected').text();
      var catName2 =  $('input[name="category_id"]').val();
      var productArrayKey =  $('input[name="productArrayKey"]').val();
      var finalCatName = catName || catName2;
      var name = $("input[name='productName']").val();
      var desc = $("textarea[name='productDesc']").val();
      var specs = $("input[name='specs[]']")
              .map(function(){return $(this).val();}).get();
      var size = $("input[name='size[]']")
              .map(function(){return $(this).val();}).get();
      var qty = $("input[name='qty[]']")
              .map(function(){return $(this).val();}).get();
      var paperType = $("input[name='paperType[]']")
              .map(function(){return $(this).val();}).get();
              // alert(finalCatName);
      if(catId == 3 || catId == 4 || catId == 5 || catId == 6 || catId == 7 || catId == 8 || catId == 9)
      {  
        if(size[0] != "" && paperType[0] != "" && qty[0] != "")
        {
        $.ajax({
          type: "POST",
          url: "/product-info-session",
          data: {catId:catId,name:name,desc:desc,specs:specs,size:size,paperType:paperType,qty:qty,productArrayKey:productArrayKey},
          
          success:function(response) {
            console.log(response);
            $('input[name="category_id"]').val(catId);
            $('#properties').load(location.href + ' #properties .col-md-3');
            location.reload(true);
            $('#productInfoForm').slideUp();
            $('#productPropertyForm').slideDown();
          },
          error: function(error){
            console.log(error)
          }
        });
      }
    }
      if(catId == 10)
      {  
        // alert(finalCatName);
        if(size[0] != "")
        {
        $.ajax({
          type: "POST",
          url: "/product-info-session",
          data: {catId:catId,name:name,desc:desc,specs:specs,size:size,productArrayKey:productArrayKey},
          
          success:function(response) {
            console.log(response);
            $('input[name="category_id"]').val(catId);
            $('#properties').load(location.href + ' #properties .col-md-3');
            location.reload(true);
            $('#productInfoForm').slideUp();
            $('#productPropertyForm').slideDown();
          },
          error: function(error){
            console.log(error)
          }
        });
      }
    }
      if(catId == 1)
      {  
        // alert(finalCatName);
        if(size[0] != "")
        {
        $.ajax({
          type: "POST",
          url: "/product-info-session",
          data: {catId:catId,name:name,desc:desc,specs:specs,size:size,productArrayKey:productArrayKey},
          
          success:function(response) {
            console.log(response);
            $('input[name="category_id"]').val(catId);
            $('#properties').load(location.href + ' #properties .col-md-3');
            location.reload(true);
            $('#productInfoForm').slideUp();
            $('#productPropertyForm').slideDown();
          },
          error: function(error){
            console.log(error)
          }
        });
      }
    }
      if(catId == 11)
      {  
        // alert(finalCatName);
        if(qty[0] != "")
        {
        $.ajax({
          type: "POST",
          url: "/product-info-session",
          data: {catId:catId,name:name,desc:desc,specs:specs,qty:qty,productArrayKey:productArrayKey},
          
          success:function(response) {
            console.log(response);
            $('input[name="category_id"]').val(catId);
            $('#properties').load(location.href + ' #properties .col-md-3');
            location.reload(true);
            $('#productInfoForm').slideUp();
            $('#productPropertyForm').slideDown();
          },
          error: function(error){
            console.log(error)
          }
        });
      }
    }
      if(catId == 2)
      {  
        if(size[0] != "" && qty[0] != "")
        {
        $.ajax({
          type: "POST",
          url: "/product-info-session",
          data: {catId:catId,name:name,desc:desc,specs:specs,size:size,qty:qty,productArrayKey:productArrayKey},
          
          success:function(response) {
            console.log(response);
            $('input[name="category_id"]').val(catId);
            $('#properties').load(location.href + ' #properties .col-md-3');
            location.reload(true);
            $('#productInfoForm').slideUp();
            $('#productPropertyForm').slideDown();
          },
          error: function(error){
            console.log(error)
          }
        });
      }
    }
    });
    $('#productPropertyNext').on('click', function(e){
      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
      e.preventDefault();
      
      var properties = $("input[name='labels[]']")
              .map(function(){return $(this).val();}).get();
      
      if(properties[0] != "")
      {
        $.ajax({
          type: "POST",
          url: "/product-property-session",
          data: $('#productPropertyForm').serialize(),
          
          success:function(response) {
            console.log(response);
            
            if(response < 1)
            {
              $('#properties').load(location.href + ' #properties .col-md-3');
              $('#qtyPricing').load(location.href + ' #qtyPricing .form-row');
            
            } else {
              $('#properties').load(location.href + ' #properties .col-md-3');
              $('#qtyPricing').load(location.href + ' #qtyPricing .form-row');
              location.reload(true);
              $('#productPropertyForm').slideUp();
              $('#productPricingForm').slideDown();
            }
          },
          error: function(error){
            console.log(error)
          }
        });
      }
    });
    $('#productPricingFinish').on('click', function(e){
      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
      e.preventDefault();
      
        $.ajax({
          type: "POST",
          url: "/product-pricing-session",
          data: $('#productPricingForm').serialize(),
          
          success:function(response) {
            console.log(response);
            /* return false; */
            if(response > 0)
            {
              location.reload();
            }
          },
          error: function(error){
            console.log(error)
          }
        });
    });
    $('#productPricingBack').on('click', function(e){
      $('#productPricingForm').slideUp();
      $('#productPropertyForm').slideDown();
    });
    $('#productPropertyBack').on('click', function(e){
      $('#productPropertyForm').slideUp();
      $('#productInfoForm').slideDown();
    });
  });
</script>

</body>
</html>
