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
          <button class="btn btn-primary" id="openAddProductForm" data-bs-toggle="modal" data-bs-target="#add-product-form">Add Product</button>
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
<div class="modal fade" id="add-product-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                  <select  name="category_id" class="form-control input-lg categorySelect" id="" name="price">
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
<div class="modal fade" id="edit-product-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                  <select  name="category_id" class="form-control input-lg categorySelect" id="" name="price">
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
            </div>
          </div>
          <div class="form-group">
              <div>
                  <button type="submit"  class="btn btn-success">
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
    let deleteUrl = "{{ route('admin.product.destroy', ':id') }}"
    let csrf_token = "{{ csrf_token() }}";
</script>

  {{-- script for display datatable --}}
  <script src="{{asset('admin/assets/js/jquery-ajax/dataTable.js') }}"></script>
  {{-- script for getting the category --}}
  <script src="{{ asset('admin/assets/js/jquery-ajax/getCategory.js') }}"></script>
  {{-- script for the adding product --}}
  <script src="{{ asset('admin/assets/js/jquery-ajax/add.js') }}"></script>
  <script src="{{ asset('admin/assets/js/jquery-ajax/edit.js') }}"></script>
  <script src="{{ asset('admin/assets/js/jquery-ajax/delete.js') }}"></script>
<script>
  
  $(document).ready(function(){

    $('#staticBackdrop').on('hidden.bs.modal', function(){
        $('#addProductForm')[0].reset();
        $('.error-msg').html('');
      });
  });
</script>
@endpush
</x-Admin-Layout>