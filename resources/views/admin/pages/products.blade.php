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
    </style>
  @endpush
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <button class="btn btn-primary" id="openAddProductForm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Product</button>
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
        
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="addProductForm" role="form" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="mode" id="formMode" value="add">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Product Name</label>
                <div>
                    <input type="text" class="form-control input-lg" id="name" name="name" value="">
                    <span class="text-danger ps-2 error-msg" id="name-error"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Description</label>
                <div>
                  <textarea class="form-control input-lg" name="description" id="description" cols="30" rows="2"></textarea>
                  <span class="text-danger ps-2 error-msg" id="description-error"></span>

                    {{-- <input type="email" class="form-control input-lg" name="email" value=""> --}}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Price</label>
                <div>
                    <input type="text" class="form-control input-lg" id="price" name="price">
                    <span class="text-danger ps-2 error-msg" id="price-error"></span>

                </div>
            </div>
            <div class="form-group">
              <label class="control-label">Category</label>
              <div>
                  <select id="categorySelect" name="category_id" class="form-control input-lg" id="" name="price">
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
                    <input type="file" class="form-control input-lg images" id="image1" name="images[]" value="" required>
                    <span class="text-danger ps-2 error-msg" id="images-error"></span>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Product Image 2</label>
                <div>
                    <input type="file" class="form-control input-lg images" id="image2" name="images[]" value="" required>
                    <span class="  text-danger ps-2 error-msg" id="images-error"></span>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Product Image 3</label>
                <div>
                    <input type="file" class="form-control input-lg images" id="image3" name="images[]" required>
                    <span class="text-danger ps-2 error-msg" id="images-error"></span>

                </div>
            </div>
            <div class="form-group">
              <label class="control-label">Product Image 4</label>
              <div>
                  <input type="file" class="form-control input-lg images" id="image4" name="images[]" required>
                  <span class="text-danger ps-2 error-msg" id="images-error"></span>

              </div>
          </div>
            </div>
          </div>
          <div class="form-group">
              <div>
                  <button type="submit" id="btn-submit" class="btn btn-success">
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
@push('scripts')
  <script>
    //passing the csrf token in the header
    $(document).ready(function(){
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
    });
    //route for the datatables
    const productJsonRoute = "{{ route('admin.product.json') }}";
    //route for getting the category for select input
    const getCategoryRoute = "{{ route('admin.category.get.json') }}";
    //route for storing the product
    const addUrl = "{{ route('admin.product.store') }}";
    let editUrl = '{{ route("admin.product.edit", ":id") }}';
    let updateUrl = '{{ route("admin.product.update", ":id") }}'
</script>

  {{-- script for display datatable --}}
  <script src="{{asset('admin/assets/js/jquery-ajax/dataTable.js') }}"></script>
  {{-- script for getting the category --}}
  <script src="{{ asset('admin/assets/js/jquery-ajax/getCategory.js') }}"></script>
  {{-- script for the adding product --}}
  <script src="{{ asset('admin/assets/js/jquery-ajax/add.js') }}"></script>
  <script src="{{ asset('admin/assets/js/jquery-ajax/edit.js') }}"></script>
<script>
  $(document).ready(function(){

    $("#addProductForm").submit(function (e) {
            e.preventDefault();
            $(".error-msg").html("");

            let formData = new FormData(this);
            let formMode = $("#formMode").val();

                
            let url = (formMode === 'add') ? addUrl : updateUrl.replace(":id", productId);
            let method = (formMode === 'add') ? 'POST' : 'PUT';
                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#staticBackdrop").modal("hide");
                        swal("Successful", response.message, "success", {
                            button: false,
                        });
                        setTimeout(() => {
                            swal.close();
                        }, 2000);
                        $(".error-msg").html("");
                        $("#addProductForm")[0].reset();
                    },
                    error: function (xhr) {
                        $(".error-msg").html("");
                        // console.log(xhr.responseJSON.errors);
                        let errors = xhr.responseJSON.errors;
                        // console.log(errors);
                        $.each(errors, function (field, error) {
                            $("#" + field + "-error").html(error);
                        });
                    },
              });
        });

    $('#staticBackdrop').on('hidden.bs.modal', function(){
        $('#addProductForm')[0].reset();
        $('.error-msg').html('');
      });
  });
</script>
@endpush
</x-Admin-Layout>