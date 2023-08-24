<x-Admin-Layout>
  @push('styles')
    <style>
      .truncated-description {
            max-width: 150px; /* Adjust the maximum width as needed */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .dataTables_wrapper .dataTables_scrollHead th:last-child,
        .dataTables_wrapper .dataTables_scrollBody td:last-child {
            white-space: nowrap;
        }

        .size-input {
            display: flex;
            flex-wrap: wrap;
        }

        .size-row {
            display: flex;
            align-items: center;
            margin-right: 20px;
            margin-bottom: 10px;
        }

        .size-row label {
            margin-right: 5px;
        }

        .size-row input[type="number"] {
            width: 95px; /* Adjust width as needed */
        }
        

    </style>
  @endpush
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <button class="btn btn-primary" id="openAddProductForm" data-bs-toggle="modal" data-bs-target="#add-form">Add Product</button>
        </div> 
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-5">
            <table id="productTable" class="display">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Category</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <tr id="loadingRow">
                    <td colspan="6" class="text-center h3 text-muted">Loading...</td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade reset-modal" id="add-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="addProductForm" role="form" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Product Name</label>
                <div>
                    <input type="text" class="form-control input-lg"  name="name" value="">
                    <span class="text-danger ps-2 error-msg name-error" id=""></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Description</label>
                <div>
                  <textarea class="form-control input-lg" name="description"  cols="30" rows="2"></textarea>
                  <span class="text-danger ps-2 error-msg description-error" id=""></span>

                    {{-- <input type="email" class="form-control input-lg" name="email" value=""> --}}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Price</label>
                <div>
                    <input type="text" class="form-control input-lg"  name="price">
                    <span class="text-danger ps-2 error-msg price-error" id=""></span>

                </div>
            </div>
            <div class="form-group">
              <label class="control-label">Category</label>
              <div>
                  <select  name="category_id" class="form-control input-lg category_id" id="" name="price">
                      <option value="" disabled selected>Select Category</option>
                  </select>
                  <span class="text-danger ps-2 error-msg category_id-error" id=""></span>

              </div>
            </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Product Image 1</label>
                <div>
                    <input type="file" class="form-control input-lg images"  name="images[]" value="" required>
                    <span class="text-danger ps-2 error-msg " id=""></span>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Product Image 2</label>
                <div>
                    <input type="file" class="form-control input-lg images"  name="images[]" value="" required>
                    <span class="  text-danger ps-2 error-msg" id=""></span>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Product Image 3</label>
                <div>
                    <input type="file" class="form-control input-lg images"  name="images[]" required>
                    <span class="text-danger ps-2 error-msg" id=""></span>

                </div>
            </div>
            <div class="form-group">
              <label class="control-label">Product Image 4</label>
              <div>
                  <input type="file" class="form-control input-lg images"  name="images[]" required>
                  <span class="text-danger ps-2 error-msg" id=""></span>

              </div>
          </div>
          <div class="size-input form-group">
            {{-- the stock per size input will append here --}}
          </div>
        
            </div>
          </div>
          <div class="form-group">
              <div>
                  <button type="submit" id="add-btn" class="btn btn-success">
                      Add Product
                  </button>
              </div>
          </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="close-modal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
<div class="modal fade reset-modal" id="edit-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit existing product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="editProductForm" role="form" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Product Name</label>
                <div>
                    <input type="text" class="form-control input-lg" id="name" name="name" value="">
                    <span class="text-danger ps-2 error-msg name-error" id=""></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Description</label>
                <div>
                  <textarea class="form-control input-lg" name="description" id="description" cols="30" rows="2"></textarea>
                  <span class="text-danger ps-2 error-msg description-error" id=""></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Price</label>
                <div>
                    <input type="text" class="form-control input-lg" id="price" name="price">
                    <span class="text-danger ps-2 error-msg price-error" id=""></span>

                </div>
            </div>
            <div class="form-group">
              <label class="control-label">Category</label>
              <div>
                  <select  name="category_id" class="form-control input-lg category_id" id="" name="price">
                      <option value="" disabled selected>Select Category</option>
                  </select>
                  <span class="text-danger ps-2 error-msg" id="category_id-error"></span>

              </div>
            </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Product Image 1</label>
                <div>
                    <input type="file" class="form-control input-lg images" id="image1" name="images[]" value="" >
                    <span class="text-danger ps-2 error-msg" id=""></span>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Product Image 2</label>
                <div>
                    <input type="file" class="form-control input-lg images" id="image2" name="images[]" value="" >
                    <span class="  text-danger ps-2 error-msg" id=""></span>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Product Image 3</label>
                <div>
                    <input type="file" class="form-control input-lg images" id="image3" name="images[]" >
                    <span class="text-danger ps-2 error-msg" id=""></span>

                </div>
            </div>
            <div class="form-group">
              <label class="control-label">Product Image 4</label>
              <div>
                  <input type="file" class="form-control input-lg images" id="image4" name="images[]" >
                  <span class="text-danger ps-2 error-msg" id=""></span>

              </div>
          </div>
          <div class="size-input form-group">
            {{-- the stock per size input will append here --}}
          </div>
        </div>
          </div>
          <div class="form-group">
              <div>
                  <button type="submit" id="update-btn"  class="btn btn-success">
                      Update Product
                  </button>
              </div>
          </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="close-modal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>  
@push('scripts')
  {{-- script for display datatable & for add, edit and delete data --}}
  <script src="{{asset('admin/assets/js/jquery-ajax/dataTable.js') }}"></script>
  {{-- script for displaying the categories --}}
  <script src="{{ asset('admin/assets/js/jquery-ajax/getCategory.js') }}"></script>
<script>
  
  $(document).ready(function(){
    
    //csrf token for http request
    $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
    //route for the datatables
    const productJsonRoute = "{{ route('admin.product.json') }}";
     //route for getting the category for select input
    const getCategoryRoute = "{{ route('admin.category.get.json') }}";
    // route for adding product
    const addUrl = "{{ route('admin.product.store') }}";
    //route for edit product, open the form with populated data
    let editUrl = '{{ route("admin.product.edit", ":id") }}';
    //route for updating the existing data
    let updateUrl = '{{ route("admin.product.update", ":id") }}'
    //route for deleting existing data
    let deleteUrl = "{{ route('admin.product.destroy', ':id') }}"
    // Initialize the columns configuration for datatable
    let columnsConfig = [
            { data: "name" },
            {
                data: "description",
                render: function (data, type, row) {
                    if (type === "display" && data.length > 50) {
                        return data.substr(0, 50) + "...";
                    }
                    return data || "";
                },
            },
            { data: "price" },
            { data: "category.name", name: "category.name", orderable: false },
            {
                data: "created_at",
                render: function (data, type, row) {
                    const date = new Date(data);
                    const day = date.getDate();
                    const month = date.toLocaleString("default", {
                        month: "long",
                    });
                    const year = date.getFullYear();
                    const formatDate = `${month} ${day}, ${year}`;
                    return formatDate;
              },
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                width: "100px",
                render: function (data, type, row) {
                    return `
                    <button id="edit-btn" class="btn btn-primary btn-sm edit-button px-2 py-1" data-id="${data.id}"><i class="fa-regular fa-pen-to-square fs-6" style="color: #ffffff;"></i></button>
                    <button class="btn btn-danger btn-sm delete-button px-2 py-1" data-id="${data.id}"><i class="fa-solid fa-trash-can fs-6" style="color: #ffffff;"></i></button>
                `;
                },
            },
        ];

        $.get("{{ route('get.sizes.json') }}", function(sizes){
          sizes.forEach(function(size){
            
            let label = $('<label>')
                .attr('for', 'size_' + size.name)
                .text(size.name)
                .appendTo('.size-input');   
          
            let sizeInput = $('<input>')
                .attr('type', 'number')
                .attr('name', 'sizes[' + size.name + ']')
                .attr('placeholder', size.name + ' stocks')
                .attr('class', 'form-control')
                .attr('min', '1')
                .appendTo('.size-input')

          });
        });   

        //displaying product data into the datatable
        initializedDataTable('#productTable', productJsonRoute, columnsConfig);
        
        //Get the category data
        getCategories(getCategoryRoute, ".category_id");
        
        //adding new product
        add("#openAddProductForm", "#addProductForm", addUrl, "Add product", '#productTable');

        // Edit the existing product
        edit("#editProductForm", updateUrl, editUrl, '#productTable', 'Update Product',  "{{ csrf_token() }}");
        
        //Deleting the product
        deleteData("#productTable", deleteUrl)
        
        $('.reset-modal').on('hidden.bs.modal', function(){
        $('#addProductForm')[0].reset();
        $('#editProductForm')[0].reset();
        $('.error-msg').html('');
      });
  });
</script>
@endpush
</x-Admin-Layout>